<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckBannedStatusListener
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
    public function handle(object $event): void
    {
        $usersToUnban = User::whereNotNull('banned_until')
            ->whereDate('banned_until', now()->toDateString())
            ->get();

        foreach ($usersToUnban as $user) {
            $user->update([
                'banned_until' => null,
                'banned' => 0,
            ]);
        }
    }
}
