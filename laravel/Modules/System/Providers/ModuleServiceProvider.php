<?php

namespace Modules\System\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Http\Resources\Json\Resource;
use Modules\System\Console\Install;

class ModuleServiceProvider extends ServiceProvider
{
    protected $commands = [
        Install::class
    ];

    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();

        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'system');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'system');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'system');
        $this->loadConfigsFrom(__DIR__.'/../config');

    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->registerEloquentFactoriesFrom(__DIR__.'/../Database/Factories');
        $this->registerConsoleCommands();
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

    protected function registerConsoleCommands(){
        $this->commands($this->commands);
    }
}
