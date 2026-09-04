<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // This used to be `fn ($request) => $request->is('api/*')`, which
        // meant only /api/* routes ever got a JSON error response —
        // including on a validation failure. Every AJAX form on the public
        // site (the booking form included) lives under plain web routes and
        // explicitly asks for JSON (Accept: application/json,
        // X-Requested-With: XMLHttpRequest), but got an HTML redirect page
        // back instead, which its `await response.json()` can't parse. This
        // restores Laravel's actual default behavior (respect what the
        // request asked for) instead of only ever trusting the URL prefix.
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
