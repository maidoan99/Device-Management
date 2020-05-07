<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Repositories\Contracts\UserRepositoryInterface',
            'App\Repositories\Eloquents\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\DeviceRepositoryInterface',
            'App\Repositories\Eloquents\DeviceRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\RequestRepositoryInterface',
            'App\Repositories\Eloquents\RequestRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
