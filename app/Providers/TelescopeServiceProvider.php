<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\IncomingEntry;

class TelescopeServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->gate();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->hideSensitiveRequestDetails();

        if (app()->environment('production')) {
            $allowedIp = env('TELESCOPE_ALLOWED_IP');
            Telescope::filter(function (IncomingEntry $entry) use ($allowedIp) {
                return request()->ip() === $allowedIp;
            });
        }
    }

    /**
     * Authorize the user to view Telescope.
     */
    public function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            // Autorise uniquement l'utilisateur avec l'ID 1
            return $user->id === 1;
        });
    }

    /**
     * Hide sensitive request details from Telescope.
     */
    protected function hideSensitiveRequestDetails()
    {
        if (!app()->environment('production')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);
        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }
}
