<?php

namespace Modules\Account\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;


class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'account');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'account');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'account');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(Factory::class)->load($path);
    }
}
