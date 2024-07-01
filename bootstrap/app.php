<?php

use App\Exceptions\ValidationException;
use App\Http\Middleware\RequireJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as DefaultValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('api', RequireJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (DefaultValidationException $exception, Request $request) {
            if (! $request->wantsJson()) {
                return null;
            }

            throw ValidationException::withMessages(
                $exception->validator->getMessageBag()->getMessages()
            );
        });
    })
    ->create();
