<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'twofactor' => \App\Http\Middleware\TwoFactorMiddleware::class,
        ]);
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\TwoFactorMiddleware::class,
        ]);
        $middleware->redirectTo(
            guests: '/login',
            users: '/home',
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
