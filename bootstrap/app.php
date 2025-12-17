<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'creator' => \App\Http\Middleware\CreatorMiddleware::class,
            'premium' => \App\Http\Middleware\IsPremiumUser::class,
            'record.view' => \App\Http\Middleware\RecordView::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([
        \App\Providers\AppServiceProvider::class,
    ])
    ->withCommands([
        \App\Console\Commands\UpdateEbookRatingsCommand::class,
    ])->create();
