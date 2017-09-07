<?php

namespace WuFan\Geetest;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class GeetestServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/geetest.php' => config_path('geetest.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'geetest');
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/geetest'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/assets/js/gt.js' => public_path('vendor/geetest/js/gt.js'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/resources/assets/js/components' => resource_path('assets/js/components/vendor/geetest'),
        ], 'components');

        Validator::extend('geetest', 'WuFan\Geetest\App\Validators\GeetestValidator@validate');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
