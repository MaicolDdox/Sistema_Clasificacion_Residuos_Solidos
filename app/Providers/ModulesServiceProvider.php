<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Registra de forma dinámica los service providers definidos en module.json
     * de cada módulo dentro de /modules.
     */
    public function register(): void
    {
        $modulesPath = base_path('modules');

        if (! is_dir($modulesPath)) {
            return;
        }

        foreach (scandir($modulesPath) as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            $manifestPath = $modulesPath.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'module.json';

            if (! is_file($manifestPath)) {
                continue;
            }

            $manifest = $this->readManifest($manifestPath);

            if (empty($manifest['providers']) || ! is_array($manifest['providers'])) {
                continue;
            }

            foreach ($manifest['providers'] as $provider) {
                // Registrar el provider declarado por el módulo.
                $this->app->register($provider);
            }
        }
    }

    public function boot(): void
    {
        // Nada que hacer en boot; todo sucede en register.
    }

    /**
     * Lee y decodifica el archivo module.json, evitando errores de JSON mal formado.
     */
    private function readManifest(string $manifestPath): array
    {
        $content = file_get_contents($manifestPath);

        if ($content === false) {
            return [];
        }

        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }
}
