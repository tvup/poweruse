<?php

namespace App\Providers;

use App\Services\GetSpotPrices;
use App\Services\Interfaces\GetSpotPricesInterface;
use App\Services\Mocks\GetSpotPricesMock;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //We want to make sure that Vite doesn't use the default "build/"-path when resolving assets
        //Here we can take advantage of the fact that the class is a singleton.
        app()->make(Vite::class)->useBuildDirectory('');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Tvup\EwiiApi\EwiiApiInterface',
            'Tvup\EwiiApi\EwiiApi'
        );

        if (app()->environment('local')) {
            $this->app->bind(GetSpotPricesInterface::class, GetSpotPricesMock::class);
        } else {
            $this->app->bind(GetSpotPricesInterface::class, GetSpotPrices::class);
        }
    }
}
