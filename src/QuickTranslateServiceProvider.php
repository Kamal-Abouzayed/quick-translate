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
    }

    public function boot()
    {
        // Load the helper file
        require_once __DIR__ . '/helpers.php';
    }
}
