<?php

namespace Modules\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings especificos del modulo pueden declararse aqui.
    }

    public function boot(): void
    {
        $viewsPath = __DIR__.'/../Resources/views';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom($viewsPath, 'dashboard');
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'dashboard');
    }
}
