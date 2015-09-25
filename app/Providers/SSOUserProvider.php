<?php namespace APO\Providers;

use APO\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class SSOUserProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Request $request)
	{
        view()->composer('*',function($view) {
            return $view->with('currentUser',LoginController::currentUser());
        });
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
