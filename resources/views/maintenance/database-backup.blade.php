<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="database-backup" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-auth.navbars.navs.auth pageTitle="Database Backup &amp; Restore"></x-auth.navbars.navs.auth>

        <div class="loading" id="loading" style="display: none !important">
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="loading" class="icons">
        </div>

        <div class="container-fluid py-4">

            {{-- ===== RESTORE CONFIRM MODAL ===== --}}
            <div class="modal fade" id="modalRestore" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger" style="border-bottom: none !important">
                            <h6 class="text-white"><i class="material-icons-round" style="vertical-align:middle">warning</i> Confirm Database Restore</h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning text-sm mb-3">
                                <strong>Warning:</strong> This will <strong>DROP and RECREATE all tables</strong> from the selected backup.
                                All current data will be <strong>permanently overwritten</strong>.
                                Consider enabling Laravel maintenance mode before proceeding.
                            </div>
                            <p class="text-sm mb-1">Restoring: <strong id="restoreFilenameDisplay"></strong></p>
                            <label class="form-label text-bold mt-2">Type <code>RESTORE</code> to confirm:</label>
                            <div class="input-group input-group-outline">
                                <input type="text" id="restoreConfirmInput" class="form-control" placeholder="RESTORE" autocomplete="off">
                            </div>
                            <input type="hidden" id="restoreFilenameHidden">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn bg-gradient-danger btn-sm" id="btnConfirmRestore">
                                <i class="material-icons-round" style="vertical-align:middle;font-size:16px">restore</i> Restore Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ===== END RESTORE MODAL ===== --}}

            {{-- ===== STATUS CHECKS ===== --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6><i class="material-icons-round" style="vertical-align:middle">health_and_safety</i> System Status</h6>
                        </div>
                        <div class="card-body pt-2">
                            <div class="row">
                                @php
                                    $checks = [
                                        'exec_enabled'     => ['label' => 'exec() enabled',        'ok_msg' => 'Available',       'fail_msg' => 'Disabled — contact hosting'],
                                        'pg_dump_found'    => ['label' => 'pg_dump binary',         'ok_msg' => 'Found',           'fail_msg' => 'Not found — see .ebextensions/02_postgresql_client.config'],
                                        'pg_restore_found' => ['label' => 'pg_restore binary',      'ok_msg' => 'Found',           'fail_msg' => 'Not found — see .ebextensions/02_postgresql_client.config'],
                                        'tmp_writable'     => ['label' => '/tmp writable',          'ok_msg' => 'Writable',        'fail_msg' => 'Not writable'],
                                        's3_reachable'     => ['label' => 'S3 bucket reachable',    'ok_msg' => 'Reachable',       'fail_msg' => 'Unreachable — check AWS credentials'],
                                    ];
                                @endphp
                                @foreach ($checks as $key => $meta)
                                    <div class="col-md-2 col-6 text-center mb-2">
                                        @if ($statusChecks[$key])
                                            <span class="badge badge-sm bg-gradient-success">✓</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">✗</span>
                                        @endif
                                        <p class="text-xs mt-1 mb-0 text-bold">{{ $meta['label'] }}</p>
                                        <p class="text-xs text-{{ $statusChecks[$key] ? 'success' : 'danger' }} mb-0">
                                            {{ $statusChecks[$key] ? $meta['ok_msg'] : $meta['fail_msg'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== CREATE BACKUP ===== --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6><i class="material-icons-round" style="vertical-align:middle">backup</i> Create Backup</h6>
                            <p class="text-sm text-secondary mb-0">
                                Creates a PostgreSQL custom-format dump and uploads it to S3 (<code>{{ env('AWS_BUCKET') }}/database-backups/</code>).
                                A maximum of 30 backups are retained — older ones are pruned automatically.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-lg-5 col-12">
                                    <label class="form-label text-bold">Label <span class="text-secondary">(optional, alphanumeric, max 40 chars)</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" id="backupLabel" class="form-control" placeholder="e.g. before-migration"
                                               maxlength="40" pattern="[a-zA-Z0-9_\-]*">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12 mt-3 mt-lg-0">
                                    <button class="btn bg-gradient-danger w-100" id="btnCreateBackup"
                                            @if(!$statusChecks['exec_enabled'] || !$statusChecks['pg_dump_found']) disabled @endif>
                                        <i class="material-icons-round" style="vertical-align:middle">backup</i>
                                        Backup Now
                                    </button>
                                </div>
                            </div>
                            <div id="backupProgress" style="display:none;" class="mt-3">
                                <div class="alert alert-info text-sm">
                                    <i class="material-icons-round" style="vertical-align:middle;font-size:16px">hourglass_empty</i>
                                    Creating backup — this may take several minutes for large databases. Please wait…
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== BACKUPS LIST ===== --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6><i class="material-icons-round" style="vertical-align:middle">folder</i>
                                Stored Backups
                                <span class="badge bg-gradient-secondary ms-1">{{ count($backups) }}</span>
                            </h6>
                            <button class="btn btn-sm bg-gradient-secondary" onclick="location.reload()">
                                <i class="material-icons-round" style="vertical-align:middle;font-size:16px">refresh</i> Refresh
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3">Filename</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Size</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Created ({{ config('app.timezone') }})</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($backups as $i => $bk)
                                            <tr id="row-{{ $i }}">
                                                <td class="ps-3">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $bk['filename'] }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $bk['size_human'] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $bk['last_modified'] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm bg-gradient-info mb-0 me-1"
                                                            onclick="downloadBackup('{{ $bk['filename'] }}')"
                                                            title="Download to local machine">
                                                        <i class="material-icons-round" style="font-size:16px;vertical-align:middle">download</i>
                                                        Download
                                                    </button>
                                                    <button class="btn btn-sm bg-gradient-warning mb-0 me-1"
                                                            onclick="openRestoreModal('{{ $bk['filename'] }}')"
                                                            @if(!$statusChecks['pg_restore_found']) disabled @endif
                                                            title="Restore this backup to the database">
                                                        <i class="material-icons-round" style="font-size:16px;vertical-align:middle">restore</i>
                                                        Restore
                                                    </button>
                                                    <button class="btn btn-sm bg-gradient-danger mb-0"
                                                            onclick="deleteBackup('{{ $bk['filename'] }}', {{ $i }})"
                                                            title="Delete this backup from S3">
                                                        <i class="material-icons-round" style="font-size:16px;vertical-align:middle">delete</i>
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-secondary py-4">
                                                    No backups found. Create your first backup above.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== BACKUP LOGS ===== --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6><i class="material-icons-round" style="vertical-align:middle">history</i> Backup Activity Log <span class="text-secondary text-sm">(last 50)</span></h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3">Action</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Filename</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Admin</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">IP Address</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($logs as $log)
                                            @php
                                                $badgeClass = match($log->action) {
                                                    'backup_created'    => 'bg-gradient-success',
                                                    'backup_restored'   => 'bg-gradient-warning',
                                                    'backup_deleted'    => 'bg-gradient-danger',
                                                    'backup_downloaded' => 'bg-gradient-info',
                                                    default             => 'bg-gradient-secondary',
                                                };
                                            @endphp
                                            <tr>
                                                <td class="ps-3">
                                                    <span class="badge badge-sm {{ $badgeClass }}">{{ str_replace('_', ' ', $log->action) }}</span>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $log->filename }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">{{ optional($log->user)->name ?? 'Unknown' }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">{{ $log->ip_address }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">{{ $log->created_at->timezone(config('app.timezone'))->format('Y-m-d H:i:s') }}</p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-secondary py-4">No backup activity yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>

    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />

    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>

    <script>
    var csrfToken = '{{ csrf_token() }}';
    var backupInProgress  = false;
    var backupElapsedTimer = null;

    // Warn if the user tries to navigate away while a backup/restore is running
    window.addEventListener('beforeunload', function (e) {
        if (backupInProgress) {
            e.preventDefault();
            e.returnValue = 'A backup or restore is still running. Leaving now will abort it.';
        }
    });

    function startElapsedTimer(elementId) {
        var seconds = 0;
        var el = document.getElementById(elementId);
        backupElapsedTimer = setInterval(function () {
            seconds++;
            var m = Math.floor(seconds / 60);
            var s = seconds % 60;
            var label = m > 0 ? m + 'm ' + s + 's' : s + 's';
            if (el) el.textContent = 'Running… ' + label + ' elapsed. Do not close this tab.';
        }, 1000);
    }

    function stopElapsedTimer() {
        if (backupElapsedTimer) {
            clearInterval(backupElapsedTimer);
            backupElapsedTimer = null;
        }
    }

    function resetBackupUI() {
        backupInProgress = false;
        stopElapsedTimer();
        document.getElementById('loading').style.display          = 'none';
        document.getElementById('backupProgress').style.display   = 'none';
        document.getElementById('btnCreateBackup').disabled       = false;
    }

    // ----------------------------------------------------------------
    // Create Backup
    // ----------------------------------------------------------------
    document.getElementById('btnCreateBackup').addEventListener('click', function () {
        var label = document.getElementById('backupLabel').value.trim();
        var pattern = /^[a-zA-Z0-9_\-]*$/;

        if (label && !pattern.test(label)) {
            Swal.fire('Invalid Label', 'Label may only contain letters, numbers, hyphens, and underscores.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Create Backup?',
            text: 'This will dump the entire database to S3. For large databases this may take several minutes. Do not close this tab until complete.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, back up now',
            customClass: { confirmButton: 'btn bg-gradient-success', cancelButton: 'btn bg-gradient-danger' },
            buttonsStyling: false,
        }).then(function (result) {
            if (!result.isConfirmed) return;

            backupInProgress = true;
            document.getElementById('btnCreateBackup').disabled = true;
            document.getElementById('backupProgress').style.display = 'block';
            document.getElementById('loading').style.display = 'block';
            startElapsedTimer('backupProgressText');

            $.ajax({
                type: 'POST',
                url: '/database-backup/create',
                data: { label: label, _token: csrfToken },
                timeout: 300000, // 5 minutes — matches Nginx fastcgi_read_timeout
                success: function (data) {
                    resetBackupUI();
                    if (data.success) {
                        Swal.fire({
                            title: 'Backup Created!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Refresh'
                        }).then(function () { location.reload(); });
                    } else {
                        Swal.fire('Backup Failed', data.message || 'Unknown error.', 'error');
                    }
                },
                error: function (xhr, status) {
                    resetBackupUI();
                    var msg;
                    if (status === 'timeout') {
                        msg = 'The request timed out after 5 minutes. The backup may still be running on the server — check the S3 bucket or refresh the page in a moment.';
                    } else {
                        msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : (xhr.responseText || 'Unknown error.');
                    }
                    Swal.fire('Backup Failed', msg, 'error');
                }
            });
        });
    });

    // ----------------------------------------------------------------
    // Download Backup
    // ----------------------------------------------------------------
    function downloadBackup(filename) {
        document.getElementById('loading').style.display = 'block';

        $.ajax({
            type: 'POST',
            url: '/database-backup/download',
            data: { filename: filename, _token: csrfToken },
            success: function (data) {
                document.getElementById('loading').style.display = 'none';
                if (data.url) {
                    window.location.href = data.url;
                } else {
                    Swal.fire('Error', 'Could not generate download link.', 'error');
                }
            },
            error: function (xhr) {
                document.getElementById('loading').style.display = 'none';
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText;
                Swal.fire('Download Failed', msg, 'error');
            }
        });
    }

    // ----------------------------------------------------------------
    // Open Restore Modal
    // ----------------------------------------------------------------
    function openRestoreModal(filename) {
        document.getElementById('restoreFilenameDisplay').textContent = filename;
        document.getElementById('restoreFilenameHidden').value = filename;
        document.getElementById('restoreConfirmInput').value = '';
        var modal = new bootstrap.Modal(document.getElementById('modalRestore'));
        modal.show();
    }

    document.getElementById('btnConfirmRestore').addEventListener('click', function () {
        var confirmText = document.getElementById('restoreConfirmInput').value.trim();
        var filename    = document.getElementById('restoreFilenameHidden').value;

        if (confirmText !== 'RESTORE') {
            Swal.fire('Type RESTORE', 'You must type RESTORE exactly to proceed.', 'warning');
            return;
        }

        bootstrap.Modal.getInstance(document.getElementById('modalRestore')).hide();
        document.getElementById('loading').style.display = 'block';

        $.ajax({
            type: 'POST',
            url: '/database-backup/restore',
            data: { filename: filename, confirm: 'RESTORE', _token: csrfToken },
            timeout: 900000, // 15 min
            success: function (data) {
                document.getElementById('loading').style.display = 'none';
                if (data.success) {
                    Swal.fire({
                        title: 'Restore Complete',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function () { location.reload(); });
                } else {
                    Swal.fire('Restore Failed', data.message || 'Unknown error.', 'error');
                }
            },
            error: function (xhr) {
                document.getElementById('loading').style.display = 'none';
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText;
                Swal.fire('Restore Failed', msg, 'error');
            }
        });
    });

    // ----------------------------------------------------------------
    // Delete Backup
    // ----------------------------------------------------------------
    function deleteBackup(filename, rowIndex) {
        Swal.fire({
            title: 'Delete Backup?',
            text: filename + ' will be permanently removed from S3.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            customClass: { confirmButton: 'btn bg-gradient-danger', cancelButton: 'btn bg-gradient-secondary' },
            buttonsStyling: false,
        }).then(function (result) {
            if (!result.isConfirmed) return;

            document.getElementById('loading').style.display = 'block';

            $.ajax({
                type: 'POST',
                url: '/database-backup/delete',
                data: { filename: filename, _token: csrfToken },
                success: function (data) {
                    document.getElementById('loading').style.display = 'none';
                    if (data.success) {
                        var row = document.getElementById('row-' + rowIndex);
                        if (row) row.remove();
                        Swal.fire('Deleted', filename + ' has been removed.', 'success');
                    } else {
                        Swal.fire('Error', data.message || 'Could not delete.', 'error');
                    }
                },
                error: function (xhr) {
                    document.getElementById('loading').style.display = 'none';
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText;
                    Swal.fire('Delete Failed', msg, 'error');
                }
            });
        });
    }
    </script>
    @endpush
</x-page-template>
