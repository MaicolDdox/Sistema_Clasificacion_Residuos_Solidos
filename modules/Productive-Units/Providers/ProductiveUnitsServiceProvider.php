<?php

namespace Modules\Areas\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ProductiveUnitsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings específicos del módulo pueden declararse aquí.
    }

    public function boot(): void
    {
        $viewsPath = __DIR__.'/../Resources/views';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom($viewsPath, 'ProductiveUnits');
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'ProductiveUnits');

    }
}
