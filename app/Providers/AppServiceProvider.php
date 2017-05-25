<?php

namespace APOSite\Providers;

use APOSite\Interfaces\SSOService;
use APOSite\Http\Controllers\Auth\CaseSSOService;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SSOService::class, CaseSSOService::class);
    }
}
