<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Database\Factories\GradingFactory;


class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GradingFactory::class, function ($app) {
            return GradingFactory::new();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
