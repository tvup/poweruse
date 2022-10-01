<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tvup\EwiiApi\EwiiApi;
use Tvup\EwiiApi\EwiiApiInterface;

class EwiiApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(EwiiApiInterface::class, function ($app) {
            return new EwiiApi();
        });
    }
}
