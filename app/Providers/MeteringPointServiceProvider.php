<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MeteringPointServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('metering_point_transformer', function () {
            return new \App\Services\Transformers\MeteringPointTransformerBase();
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
