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
        $middleware->redirectGuestsTo('/');

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $exception, $request) {
            return back()
                ->withInput()
                ->withErrors([
                    'file' => 'Upload failed: the selected file is larger than the server limit (' . ini_get('upload_max_filesize') . ').',
                ]);
        });
    })->create();