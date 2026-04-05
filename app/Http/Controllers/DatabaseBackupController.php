<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseBackupController extends Controller
{
    private const S3_PREFIX          = 'database-backups/';
    private const MAX_BACKUPS        = 30;
    private const DOWNLOAD_TTL_MIN   = 10;

    // ------------------------------------------------------------------
    // PAGE VIEW
    // ------------------------------------------------------------------

    public function index()
    {
        $this->authorizeAdmin();

        $backups      = $this->fetchS3Backups();
        $logs         = BackupLog::with('user')->latest()->take(50)->get();
        $statusChecks = $this->runStatusChecks();

        return view('maintenance.database-backup', compact('backups', 'logs', 'statusChecks'));
    }

    // ------------------------------------------------------------------
    // CREATE BACKUP
    // ------------------------------------------------------------------

    public function create(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'label' => ['nullable', 'string', 'max:40', 'regex:/^[a-zA-Z0-9_\-]*$/'],
        ]);

        $this->assertPrerequisites();

        $label    = $request->input('label') ? '-' . $request->input('label') : '';
        $ts       = Carbon::now(config('app.timezone'))->format('Y-m-d-H-i-s');
        $filename = "{$ts}{$label}.dump";
        $s3Path   = self::S3_PREFIX . $filename;
        $tmpFile  = sys_get_temp_dir() . '/' . $filename;

        set_time_limit(600);

        try {
            $this->runPgDump($tmpFile);

            $stream = fopen($tmpFile, 'rb');
            Storage::disk('s3')->put($s3Path, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $this->pruneOldBackups();
            $this->writeLog('backup_created', $filename);

            return response()->json([
                'success'  => true,
                'filename' => $filename,
                'message'  => "Backup created: {$filename}",
            ]);
        } catch (\Throwable $e) {
            Log::error('DatabaseBackup::create ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        } finally {
            @unlink($tmpFile);
        }
    }

    // ------------------------------------------------------------------
    // DOWNLOAD  (returns a short-lived signed S3 URL)
    // ------------------------------------------------------------------

    public function download(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate(['filename' => ['required', 'string']]);

        $filename = $this->sanitizeFilename($request->input('filename'));
        $s3Path   = self::S3_PREFIX . $filename;

        abort_unless(Storage::disk('s3')->exists($s3Path), 404, 'Backup not found.');

        $url = Storage::disk('s3')->temporaryUrl(
            $s3Path,
            now()->addMinutes(self::DOWNLOAD_TTL_MIN)
        );

        $this->writeLog('backup_downloaded', $filename);

        return response()->json(['url' => $url]);
    }

    // ------------------------------------------------------------------
    // RESTORE
    // ------------------------------------------------------------------

    public function restore(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'filename' => ['required', 'string'],
            'confirm'  => ['required', 'in:RESTORE'],
        ]);

        $this->assertPrerequisites();

        $filename = $this->sanitizeFilename($request->input('filename'));
        $s3Path   = self::S3_PREFIX . $filename;

        if (!Storage::disk('s3')->exists($s3Path)) {
            return response()->json(['success' => false, 'message' => 'Backup file not found on S3.'], 404);
        }

        $tmpDump = sys_get_temp_dir() . '/' . Str::random(16) . '.dump';
        set_time_limit(900);

        try {
            // Stream from S3 to temp file — avoids loading the whole dump into memory
            $s3Stream = Storage::disk('s3')->readStream($s3Path);
            $fp       = fopen($tmpDump, 'wb');

            if ($fp === false || $s3Stream === false) {
                throw new \RuntimeException('Could not open temporary file for writing.');
            }

            while (!feof($s3Stream)) {
                fwrite($fp, fread($s3Stream, 65536));
            }
            fclose($fp);
            fclose($s3Stream);

            $this->runPgRestore($tmpDump);
            $this->writeLog('backup_restored', $filename);

            return response()->json([
                'success' => true,
                'message' => "Restore completed from: {$filename}",
            ]);
        } catch (\Throwable $e) {
            Log::error('DatabaseBackup::restore ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        } finally {
            @unlink($tmpDump);
        }
    }

    // ------------------------------------------------------------------
    // DELETE
    // ------------------------------------------------------------------

    public function delete(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate(['filename' => ['required', 'string']]);

        $filename = $this->sanitizeFilename($request->input('filename'));
        $s3Path   = self::S3_PREFIX . $filename;

        abort_unless(Storage::disk('s3')->exists($s3Path), 404, 'Backup not found.');

        Storage::disk('s3')->delete($s3Path);
        $this->writeLog('backup_deleted', $filename);

        return response()->json(['success' => true]);
    }

    // ==================================================================
    // PRIVATE HELPERS
    // ==================================================================

    private function authorizeAdmin(): void
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }

    private function assertPrerequisites(): void
    {
        if (!function_exists('exec')) {
            throw new \RuntimeException(
                'exec() is disabled in PHP. Cannot run pg_dump/pg_restore.'
            );
        }

        if ($this->pgBinary('pg_dump') === '') {
            throw new \RuntimeException(
                'pg_dump not found. Install postgresql client tools on the server ' .
                '(see .ebextensions/02_postgresql_client.config).'
            );
        }
    }

    private function runStatusChecks(): array
    {
        return [
            'exec_enabled'     => function_exists('exec'),
            'pg_dump_found'    => $this->pgBinary('pg_dump') !== '',
            'pg_restore_found' => $this->pgBinary('pg_restore') !== '',
            'tmp_writable'     => is_writable(sys_get_temp_dir()),
            's3_reachable'     => $this->checkS3Reachable(),
        ];
    }

    private function checkS3Reachable(): bool
    {
        try {
            Storage::disk('s3')->exists(self::S3_PREFIX);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function runPgDump(string $outputFile): void
    {
        $bin = $this->pgBinary('pg_dump');
        $cfg = $this->dbConfig();

        $cmd = sprintf(
            'PGPASSWORD=%s PGSSLMODE=%s %s'
            . ' --host=%s --port=%d --username=%s --dbname=%s --schema=%s'
            . ' --format=custom --no-owner --no-acl --no-password'
            . ' --file=%s 2>&1',
            escapeshellarg($cfg['password']),
            escapeshellarg($cfg['sslmode']),
            escapeshellarg($bin),
            escapeshellarg($cfg['host']),
            (int) $cfg['port'],
            escapeshellarg($cfg['username']),
            escapeshellarg($cfg['database']),
            escapeshellarg($cfg['schema']),
            escapeshellarg($outputFile)
        );

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            throw new \RuntimeException(
                'pg_dump failed (exit ' . $exitCode . '): ' . implode(' | ', $output)
            );
        }

        if (!file_exists($outputFile) || filesize($outputFile) === 0) {
            throw new \RuntimeException('pg_dump produced an empty file.');
        }
    }

    private function runPgRestore(string $dumpFile): void
    {
        $bin = $this->pgBinary('pg_restore');
        $cfg = $this->dbConfig();

        $cmd = sprintf(
            'PGPASSWORD=%s PGSSLMODE=%s %s'
            . ' --host=%s --port=%d --username=%s --dbname=%s'
            . ' --clean --if-exists --no-owner --no-acl --no-password'
            . ' --format=custom %s 2>&1',
            escapeshellarg($cfg['password']),
            escapeshellarg($cfg['sslmode']),
            escapeshellarg($bin),
            escapeshellarg($cfg['host']),
            (int) $cfg['port'],
            escapeshellarg($cfg['username']),
            escapeshellarg($cfg['database']),
            escapeshellarg($dumpFile)
        );

        exec($cmd, $output, $exitCode);

        // pg_restore exits 1 for non-fatal warnings; only > 1 is a real failure
        if ($exitCode > 1) {
            throw new \RuntimeException(
                'pg_restore failed (exit ' . $exitCode . '): ' . implode(' | ', $output)
            );
        }
    }

    /**
     * Resolve the absolute path of a PostgreSQL binary.
     * Checks common locations on Amazon Linux 2 / Amazon Linux 2023.
     */
    private function pgBinary(string $tool): string
    {
        $candidates = [
            '/usr/bin/' . $tool,
            '/usr/local/bin/' . $tool,
            '/usr/lib/postgresql/16/bin/' . $tool,
            '/usr/lib/postgresql/15/bin/' . $tool,
            '/usr/lib/postgresql/14/bin/' . $tool,
            '/usr/lib/postgresql/13/bin/' . $tool,
        ];

        foreach ($candidates as $path) {
            if (is_executable($path)) {
                return $path;
            }
        }

        // Fall back to PATH resolution
        $output = [];
        exec('which ' . escapeshellarg($tool) . ' 2>/dev/null', $output, $code);

        return ($code === 0 && !empty($output[0])) ? trim($output[0]) : '';
    }

    private function dbConfig(): array
    {
        $c = config('database.connections.' . config('database.default'));

        return [
            'host'     => $c['host'],
            'port'     => $c['port'] ?? 5432,
            'username' => $c['username'],
            'password' => $c['password'],
            'database' => $c['database'],
            'schema'   => $c['schema'] ?? 'public',
            'sslmode'  => $c['sslmode'] ?? 'prefer',
        ];
    }

    private function fetchS3Backups(): array
    {
        try {
            $files   = Storage::disk('s3')->files(self::S3_PREFIX);
            $backups = [];

            foreach ($files as $file) {
                $filename = basename($file);
                if (!str_ends_with($filename, '.dump')) {
                    continue;
                }

                $sizeBytes = Storage::disk('s3')->size($file);
                $backups[] = [
                    'path'          => $file,
                    'filename'      => $filename,
                    'size_bytes'    => $sizeBytes,
                    'size_human'    => $this->humanSize($sizeBytes),
                    'last_modified' => Carbon::createFromTimestamp(
                        Storage::disk('s3')->lastModified($file)
                    )->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
                ];
            }

            // Sort newest first
            usort($backups, fn($a, $b) => strcmp($b['filename'], $a['filename']));

            return $backups;
        } catch (\Throwable $e) {
            Log::error('DatabaseBackup::fetchS3Backups ' . $e->getMessage());
            return [];
        }
    }

    private function pruneOldBackups(): void
    {
        try {
            $files = Storage::disk('s3')->files(self::S3_PREFIX);
            $dumps = array_values(array_filter($files, fn($f) => str_ends_with($f, '.dump')));

            if (count($dumps) <= self::MAX_BACKUPS) {
                return;
            }

            sort($dumps); // ascending = oldest first
            $toDelete = array_slice($dumps, 0, count($dumps) - self::MAX_BACKUPS);
            Storage::disk('s3')->delete($toDelete);
        } catch (\Throwable $e) {
            Log::warning('DatabaseBackup::pruneOldBackups ' . $e->getMessage());
        }
    }

    private function writeLog(string $action, string $filename): void
    {
        BackupLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'filename'   => $filename,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Strip path components and reject filenames with unsafe characters.
     */
    private function sanitizeFilename(string $raw): string
    {
        $base = basename($raw);

        if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $base)) {
            abort(400, 'Invalid filename.');
        }

        return $base;
    }

    private function humanSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 2) . ' GB';
        }
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
