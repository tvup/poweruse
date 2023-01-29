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
        app()->make(Vite::class)->withEntryPoints(['resources/sass/app.scss', 'resources/js/app.js'])->useBuildDirectory('');
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
