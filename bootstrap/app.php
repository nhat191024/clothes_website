<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies([
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ]);

        $middleware->redirectGuestsTo(fn(Request $request) => route('client.login.index'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
