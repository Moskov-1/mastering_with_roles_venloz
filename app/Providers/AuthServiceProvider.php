<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            // if $user is null (guest), do nothing
            if (! $user) {
                return null;
            }
            
            // bypass: super-admin always allowed
            // return $user->isSuperAdmin() ? true : null;
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
