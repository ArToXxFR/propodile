<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('update-project', function ($user, $team) {
            return $user->hasTeamRole($team, 'editor') ||
                $user->hasTeamRole($team, 'admin') ||
                $user->hasTeamRole($team, 'owner') ||
                $user->role == 'admin' ||
                $user->role == 'editor';
        });

        Gate::define('delete-project', function ($user, $team) {
            return $user->hasTeamRole($team, 'owner') ||
                $user->role == 'admin' ||
                $user->role == 'editor';
        });

        Gate::define('invite-member-project', function($user, $team) {
            return $user->hasTeamRole($team, 'owner') ||
                $user->hasTeamRole($team, 'admin');
        });
    }
}
