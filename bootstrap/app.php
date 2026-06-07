<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\CheckUserEnabled;
use App\Http\Middleware\Guest;
use App\Http\Middleware\Recruiter;
use App\Http\Middleware\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web', 'auth', 'admin'])
                ->prefix('admin')
                ->group(base_path('routes/backend.php'));

            Route::middleware(['web', 'auth', 'admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin_setting.php'));

            Route::middleware(['web'])
                ->group(base_path('routes/frontend.php'));
            Route::middleware(['web', 'auth', 'admin'])
                ->prefix('admin')
                ->group(base_path('routes/cms.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'     => Admin::class,
            'guest'     => Guest::class,
            'enabled'   => CheckUserEnabled::class,
        ]);

        // Ensure web middleware group includes CSRF protection
        $middleware->web(append: [
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $middleware->appendToGroup('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        // CSRF token validation exceptions
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'api/v1/webhooks/stripe',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // $schedule->job(new SyncShopifyProductsJob())->dailyAt('02:00');

    })
    ->create();
