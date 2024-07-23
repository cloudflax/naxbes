<?php

namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * This class handles the registration of event listeners and subscribers for the project module.
 * It extends the base EventServiceProvider provided by Laravel.
 *
 * @package Modules\Project\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * This array maps events to their respective listeners.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered automatically.
     *
     * When set to true, Laravel will automatically discover event listeners in the specified directories.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     *
     * This method is intended to register event listeners specifically for handling email verification.
     *
     * @return void
     */
    protected function configureEmailVerification(): void
    {
        // Add the logic to configure email verification event listeners here.
    }
}
