<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class AuthRegisterNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(/*protected Project $project*/)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /*$this->project->create([
            'name'    => 'Shared - Open source',
            'user_id' => $event->user?->id,
            'selected' => true,
        ]);*/
    }
}
