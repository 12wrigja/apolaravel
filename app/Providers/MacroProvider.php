<?php namespace APOSite\Providers;

use Illuminate\Html\HtmlServiceProvider;
use APOSite\Services\Macros;

class MacroProvider extends HtmlServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->app->bindShared('form', function ($app) {
            $form = new Macros($app['html'], $app['url'], $app['session.store']->getToken());
            return $form->setSessionStore($app['session.store']);
        });
    }

}
