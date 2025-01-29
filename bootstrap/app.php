<?php

use Psr\Log\LogLevel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => App\Http\Middleware\RoleMiddleware::class,
            'secure' => App\Http\Middleware\EncryptRequestResponseMiddleware::class,
            'signature' => App\Http\Middleware\SignatureHeaderMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Menentukan level log untuk Exception tertentu
        $exceptions->level(Throwable::class, LogLevel::ERROR);

        // Menangani rendering exception untuk permintaan yang mengharapkan JSON
        $exceptions->renderable(function (Throwable $e, Request $request) {
            // if ($request->expectsJson()) {
            //     $status = 500;
            //     $message = 'Terjadi kesalahan pada server.';

            //     // Mencatat log error
            //     logger()->error('Server Error:', [
            //         'url' => $request->fullUrl(),
            //         'method' => $request->method(),
            //         'status' => $status,
            //         'message' => $e->getMessage(),
            //     ]);

            //     return new JsonResponse([
            //         'success' => false,
            //         'message' => $message,
            //         // 'errors' => $errors,
            //     ], $status);
            // }
        });
    })->create();
