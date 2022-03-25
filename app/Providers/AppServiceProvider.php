<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FlightConsultService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlightConsultService::class, function ($app) {
            return new FlightConsultService();
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
