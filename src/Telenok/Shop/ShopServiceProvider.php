<?php namespace Telenok\Shop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../../view'), 'shop');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../../lang'), 'shop');

        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path()], 'resourcesapp');
        
        include __DIR__ . '/../../config/routes.php';
        include __DIR__ . '/../../config/event.php';
    }

    public function provides()
    {
        return [];
    }

    public function register()
    {
    }
}