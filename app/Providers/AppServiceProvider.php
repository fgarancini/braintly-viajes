<?php

namespace App\Providers;

use App\Models\Flight;
use App\Services\FlightService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlightService::class, function ($app) {
            return new FlightService($app->make(Flight::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
