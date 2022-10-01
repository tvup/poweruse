<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tvup\ElOverblikApi\ElOverblikApi;

class ElOverblikApiServiceProvider extends ServiceProvider
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
    public function register()
    {
        $this->app->bind('Tvup\ElOverblikApi\ElOverblikApiInterface', function($app, $params)
        {
            $refreshToken = isset($params['refreshToken']) ? $params['refreshToken'] : null;

            return new ElOverblikApi($refreshToken);
        });
    }
}
