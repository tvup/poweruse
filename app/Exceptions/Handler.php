<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            try {
                if (config('services.incident_server.url')) {
                    $this->fejlvarp_exception_handler($e);
                }
            } catch (\Exception $fejlVarpException) {
                logger()->error('Couldn\'t report to fejlvarp: ' . $fejlVarpException->getMessage());
                logger()->error('Original error: ' . $e->getMessage());
            }
        });
    }

    /**
     * @param \Throwable $exception
     * @throws \JsonException
     */
    private function fejlvarp_exception_handler(Throwable $exception) : void
    {
        // Generate unique hash from message + file + line number
        // We strip out revision-part of the file name.
        // Assuming a standard capistrano deployment path, this will prevent duplicates across deploys.
        $environment = config('app.env');
        $appName = config('app.name') . '-' . $environment;
        $hash = $appName . $exception->getMessage() . preg_replace('~revisions/[0-9]{14}/~', '--', $exception->getFile()) . $exception->getLine();
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query(
                    [
                        'hash' => md5($hash),
                        'subject' => $exception->getMessage(),
                        'data' => json_encode([
                            'application' => $appName,
                            'error' => [
                                'type' => get_class($exception),
                                'message' => $exception->getMessage(),
                                'code' => $exception->getCode(),
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine(),
                                'trace' => $exception->getTraceAsString(),
                            ],
                            'environment' => [
                                'GET' => $_GET ?: null,
                                'POST' => $_POST ?: null,
                                'SERVER' => $_SERVER ?: null,
                                'SESSION' => $_SESSION ?? null,
                            ],
                        ], JSON_THROW_ON_ERROR),
                    ]
                )],
        ];
        $context = stream_context_create($opts);
        /** @var string $incidentServerUrl */
        $incidentServerUrl = config('services.incident_server.url');
        $content = file_get_contents($incidentServerUrl, false, $context);
    }
}
