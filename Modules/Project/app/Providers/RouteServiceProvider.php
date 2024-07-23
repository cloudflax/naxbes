<?php

namespace Modules\Project\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 *
 * This class is responsible for defining the route configuration for the Project module.
 * It extends the base RouteServiceProvider provided by Laravel.
 *
 * @package Modules\Project\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern-based filters here.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * This method is used to map the web and API routes for the module.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * They are intended for web-based interaction.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(module_path('Project', '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless and are intended for API interactions.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->name('api.')
            ->group(module_path('Project', '/routes/api.php'));
    }
}
