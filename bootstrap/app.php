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
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'panel' => \App\Http\Middleware\CheckPanelAccess::class,
            'admin.session' => \App\Http\Middleware\StartAdminSession::class,
            'user.session' => \App\Http\Middleware\StartUserSession::class,
        ]);
        
        // Priority middleware - runs before StartSession
        $middleware->priority([
            \App\Http\Middleware\StartAdminSession::class,
            \App\Http\Middleware\StartUserSession::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        // Add SetLocale middleware to web group
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
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
