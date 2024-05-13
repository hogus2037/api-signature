<?php

namespace Hogus\ApiSignature;

use Illuminate\Support\ServiceProvider;

class ApiSignatureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sign.php' => config_path('sign.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/sign.php', 'sign'
        );

        $this->registerFacades();
    }

    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    protected function registerFacades()
    {
        $this->app->singleton('signature', function ($app) {
            return new ApiSignatureManager($app);
        });
    }

}
