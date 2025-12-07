# Sistema de Clasificación de Residuos Sólidos

Proyecto Laravel 12 con Livewire (Flux/Volt) y arquitectura modular para gestionar áreas, unidades productivas, residuos y permisos. Este documento describe dependencias, arquitectura, patrones de UI y pasos de ejecución para que el equipo continúe el desarrollo de forma consistente.

## Stack y dependencias clave
- **Backend:** PHP 8.2+, Laravel 12, Laravel Fortify.
- **UI:** Livewire Flux/Volt, Tailwind CSS (via Vite).
- **Autorización:** spatie/laravel-permission (middlewares `permission`, `role`, `role_or_permission` alias en `bootstrap/app.php`).
- **PDF:** spatie/laravel-pdf.
- **Frontend assets vía CDN:** AOS, TomSelect, DataTables (CSS/JS) cargados en parciales Blade.
- **Arquitectura modular:** módulos en `modules/` con `module.json` que declara `providers` y PSR-4. `App\Providers\ModulesServiceProvider` registra dinámicamente cada `module.json`.

## Arquitectura y estructura
- **Core Laravel:** `app/`, `routes/`, `config/`, `resources/`, `public/`.
- **Módulos (monolito modular):** `modules/<Modulo>/`
  - `Config/`, `Database/Migrations/`, `Http/Controllers/`, `Models/`, `Providers/`, `Resources/views/`, `Routes/web.php`, `Services/`.
  - Manifiesto: `modules/<Modulo>/module.json`.
  - Providers se cargan vía `bootstrap/providers.php` -> `App\Providers\ModulesServiceProvider`.
- **Autoload PSR-4:** `Modules\\` apunta a `modules/` en `composer.json`.
- **Vistas compartidas / layout:**
  - Sidebar principal: `resources/views/components/layouts/app/sidebar.blade.php`. Menús por sección en `resources/views/components/layouts/app/menu/*`.
  - Layout base: `<x-layouts.app>` en vistas internas de módulos.
  - Parciales de estilos/CDN: `resources/views/partials/librerias-cdn.blade.php`, `partials/footer-script-cdn.blade.php`, `partials/styles.blade.php`.
  - Mensajes de sesión: `resources/views/partials/session-message.blade.php`.
- **Recursos del módulo Áreas:** ejemplo de implementación de DataTable y AJAX en `modules/Areas/Resources/views/areas-list.blade.php` y `Modules\Areas\Http\Controllers\AreaController`.
- **Recursos del módulo Unidades Productivas:** `modules/ProductiveUnits/Resources/views/productiveUnits-list.blade.php` y `Modules\ProductiveUnits\Http\Controllers\ProductiveUnitController`.

## Diseño y estilo
- **Tailwind** con paleta clara basada en tonos `emerald/teal` y fondos suaves (`bg-slate-*`, `bg-emerald-50`).
- **Animaciones:** AOS para entradas suaves; se incluye desde `partials/footer-script-cdn`.
- **Tablas:** DataTables con carga AJAX y idioma español (`/i18n/es-ES.json`). Buscador custom en la barra de herramientas; se oculta el buscador nativo con `dom: 'lrtip'`.
- **Componentización:** acciones en tablas separadas en parciales (ej. `areas::partials.areas-actions`, `productiveunits::partials.productiveUnits-actions`) para reutilizar botones show/edit/delete.

## Sidebar: cómo agregar ítems
1. Editar `resources/views/components/layouts/app/sidebar.blade.php`.
2. Cada grupo de menú está en un include: `components/layouts/app/menu/<sección>/<...>-list.blade.php`.
3. Para un nuevo ítem:
   - Crear/editar el parcial de menú correspondiente bajo `resources/views/components/layouts/app/menu/`.
   - Añadir el include en el sidebar si es una sección nueva.
   - Asegurar que la ruta (`route('nombre.ruta')`) existe en el módulo correspondiente (`modules/<Modulo>/Routes/web.php`).

## Parciales de scripts: cuándo incluir
- Usa `@include('partials.footer-script-cdn')` en vistas que requieran:
  - DataTables (JS/CSS via CDN)
  - TomSelect
  - AOS
- El layout principal ya incluye `partials.librerias-cdn` para CSS/JS de Vite y estilos globales; solo incluye `footer-script-cdn` cuando la vista usa esos plugins.

## Comandos habituales
```bash
# Instalación inicial
composer install
npm install

# Build/desarrollo frontend
npm run dev          # watcher Vite
npm run build        # build de producción

# Servidor y migraciones
php artisan serve
php artisan migrate              # o --path=modules/<Modulo>/Database/Migrations
php artisan migrate:fresh --seed

# Cache/autoload
composer dump-autoload
php artisan optimize:clear
php artisan view:clear

# Seeders (ejemplo)
php artisan db:seed --class=DatabaseSeeder
```

## Flujo de datos con DataTables (ejemplo Áreas/Unidades)
1. **Ruta resource** en `modules/<Modulo>/Routes/web.php` (middleware `web, auth`).
2. **Controlador** `index` detecta `AJAX` (`$request->ajax()`) y devuelve `response()->json(['data' => ...])` con campos ya formateados y HTML de acciones renderizado con `view(...)->render()`.
3. **Vista**: DataTable inicializado apuntando a `route('<resource>.index')`, `dom: 'lrtip'` para usar buscador propio, columnas con íconos, lenguaje en español y contador de registros actualizado en `xhr`.

## Notas de permisos
- Middlewares alias en `bootstrap/app.php`: `permission`, `role`, `role_or_permission`.
- El modelo `User` usa `Spatie\Permission\Traits\HasRoles`.

## Módulos actuales
- `Areas`: catálogo de áreas, DataTable con AJAX, acciones en `areas::partials.areas-actions`.
- `ProductiveUnits`: catálogo de unidades productivas (relación con Área), DataTable con AJAX, acciones en `productiveunits::partials.productiveUnits-actions`.
- `Wastes`: estructura base (pendiente implementar vistas/controladores/acciones).

## Rutas y navegación
- Las rutas web de módulos se definen en `modules/<Modulo>/Routes/web.php` y se cargan vía providers del módulo.
- El sidebar utiliza `route()` para navegación; asegúrate de registrar los nombres de ruta al agregar nuevas vistas.

## Convenciones
- ASCII-only en código/fuentes para evitar problemas de encoding.
- Componentes Blade para acciones repetitivas (botones show/edit/delete).
- Usar `ModulesServiceProvider` y `module.json` para registrar nuevos módulos y sus providers.
