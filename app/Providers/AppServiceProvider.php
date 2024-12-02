<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Applique le style Bootstrap à la pagination
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Autres services à enregistrer, si nécessaire
    }
}
