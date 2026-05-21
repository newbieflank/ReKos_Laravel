<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' && request()->getHost() === 'azakaria.my.id') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \App\Models\Tenant::observe(\App\Observers\TenantObserver::class);
    }
}
