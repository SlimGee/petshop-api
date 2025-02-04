<?php

use App\Http\Middleware\RequireJson;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;
use RonasIT\Support\AutoDoc\Http\Middleware\AutoDocMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('api', RequireJson::class);
        $middleware->append(AutoDocMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
