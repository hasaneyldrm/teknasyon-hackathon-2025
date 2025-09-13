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
        // Set Carbon locale to Turkish
        \Carbon\Carbon::setLocale('tr');
        setlocale(LC_TIME, 'tr_TR.UTF-8');
    }
}
