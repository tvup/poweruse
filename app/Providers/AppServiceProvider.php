<?php

namespace App\Providers;

use App\Models\Passport\Client;
use App\Services\GetSpotPrices;
use App\Services\Interfaces\GetSpotPricesInterface;
use App\Services\Mocks\GetSpotPricesMock;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::useClientModel(Client::class);

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
        $spotServiceProvider = config('services.spot_price_provider');
        if (!$spotServiceProvider) {
            if (app()->environment('local')) {
                $this->app->bind(GetSpotPricesInterface::class, GetSpotPricesMock::class);
            } else {
                $this->app->bind(GetSpotPricesInterface::class, GetSpotPrices::class);
            }
        } else {
            $this->app->bind(GetSpotPricesInterface::class, $spotServiceProvider);
        }
    }
}
