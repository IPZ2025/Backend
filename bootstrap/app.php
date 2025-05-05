<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::redirect("/", route("l5-swagger.default.api"));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is("api/*")) {
                return true;
            }
            return $request->expectsJson();
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json(
                [
                    "error" => $e->getMessage(),
                    "exception" => $e::class,
                    "trace" => $e->getTrace()
                ],
                $e->getStatusCode(),
            );
        });
    })->create();
