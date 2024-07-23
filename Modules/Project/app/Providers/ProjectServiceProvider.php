<?php

namespace Modules\Project\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Project\Models\Interfaces\IProject;
use Modules\Project\Models\Project;

/**
 * Class ProjectServiceProvider
 *
 * This class handles the registration and bootstrapping of services, commands, translations,
 * configurations, and views for the Project module.
 *
 * @package Modules\Project\Providers
 */
class ProjectServiceProvider extends ServiceProvider
{
    /**
     * The name of the module.
     *
     * @var string
     */
    protected string $moduleName = 'Project';

    /**
     * The lowercase name of the module.
     *
     * @var string
     */
    protected string $moduleNameLower = 'project';

    /**
     * Boot the application events.
     *
     * This method is called after all other services have been registered, meaning
     * you have access to all other services that have been registered by the framework.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    /**
     * Register the service provider.
     *
     * This method is used to bind any classes or functionality into the service container.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(
            IProject::class,
            Project::class
        );
    }

    /**
     * Register commands in the format of Command::class.
     *
     * This method is intended to register Artisan commands specific to the module.
     */
    protected function registerCommands(): void
    {
        // Register module-specific commands here.
        // Example:
        // $this->commands([
        //     \Modules\Project\Console\SomeCommand::class,
        // ]);
    }

    /**
     * Register command schedules.
     *
     * This method is intended to register scheduled tasks specific to the module.
     */
    protected function registerCommandSchedules(): void
    {
        // Register module-specific command schedules here.
        // Example:
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(\Illuminate\Console\Scheduling\Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     *
     * This method is intended to load the module's translation files.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }

    /**
     * Register config.
     *
     * This method is intended to publish and merge the module's configuration files.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php')
        ], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [];
    }
}
