<?php

namespace Modules\Wastes\Providers;

use Illuminate\Support\ServiceProvider;

class WastesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings especificos del modulo pueden declararse aqui.
    }

    public function boot(): void
    {
        $viewsPath = __DIR__.'/../Resources/views';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom($viewsPath, 'wastes');
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'wastes');
    }
}
