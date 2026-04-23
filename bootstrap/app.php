<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',   // ← Asegúrate que esta línea existe
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role.admin'   => \App\Http\Middleware\EnsureIsAdmin::class,
            'role.iglesia' => \App\Http\Middleware\EnsureIsIglesia::class,
            'consents'     => \App\Http\Middleware\EnsureConsentsAccepted::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();