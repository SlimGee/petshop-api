<?php

namespace App\Listeners;

use App\Events\LoggedIn;

class UpdateLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedIn $event): void
    {
        $user = $event->user;
        $user->forceFill(['last_login_at' => now()]);
        $user->save();
    }
}
