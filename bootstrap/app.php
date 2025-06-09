<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\PreventReinstall;
use Illuminate\Routing\Router;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;



$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware
        $middleware->append(EncryptCookies::class);
        $middleware->append(AddQueuedCookiesToResponse::class);
        $middleware->append(StartSession::class);
        $middleware->append(\App\Http\Middleware\SetLocale::class);
        /*
        $middleware->alias([
            'setlocale' => \App\Http\Middleware\SetLocaleFromCookie::class,
        ]);
        */

        // ✅ Route middleware (used by name in routes)
    
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'prevent.reinstall' => PreventReinstall::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling
    
    })->create();
// 👇 Register route middleware alias
app()->booted(function () {
    // AppServiceProvider.php

    config(['app.pro' => file_exists(base_path('pro.version'))]);
});


return $app;