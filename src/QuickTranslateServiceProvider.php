<?php

namespace KamalAbouzayed\QuickTranslate;

use Illuminate\Support\ServiceProvider;

class QuickTranslateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QuickTranslate::class, function ($app) {
            return new QuickTranslate();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/quick-translate.php',
            'quick-translate'
        );
    }

    public function boot()
    {
        // Load the helper file
        require_once __DIR__ . '/helpers.php';

        // Publish config file
        $this->publishes([
            __DIR__ . '/config/quick-translate.php' => config_path('quick-translate.php'),
        ], 'config');
    }
}
