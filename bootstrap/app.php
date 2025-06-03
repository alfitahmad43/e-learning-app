<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Pastikan Anda menambahkan ini jika belum ada di bagian atas:
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Gunakan method alias() seperti ini:
        $middleware->alias([
            'role' => RoleMiddleware::class, // Ini cara yang benar
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Contoh alias lain jika ada
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Contoh alias lain jika ada
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Contoh alias lain jika ada
            // tambahkan alias middleware lain yang Anda butuhkan di sini
        ]);

        // Jika Anda perlu menambahkan middleware ke grup 'web' atau 'api' secara global:
        // $middleware->web(append: [
        //     \App\Http\Middleware\AnotherWebMiddleware::class,
        // ]);

        // $middleware->api(prepend: [
        //     \App\Http\Middleware\AnotherApiMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();