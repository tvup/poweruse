<?php

namespace App\Providers;

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
    }
}
