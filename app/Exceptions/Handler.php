<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Gracefully handle bad or tampered encrypted payloads (e.g. old links, corrupted cookies)
        $this->renderable(function (DecryptException $e, $request) {
            Log::warning('DecryptException triggered', [
                'path'    => $request->path(),
                'user'    => optional($request->user())->id,
                'ip'      => $request->ip(),
                'message' => $e->getMessage(),
            ]);

            return response()->view('errors.404', [], 404);
        });
    }
}
