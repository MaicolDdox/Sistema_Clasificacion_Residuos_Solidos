# Causa raíz: toasts duplicados

## Síntoma
Al ejecutar acciones con `session('success')` o `session('error')`, se mostraban dos toasts iguales.

## Causa exacta
En el layout autenticado se cargaba Alpine dos veces:

1. Por CDN en `resources/views/partials/librerias-cdn.blade.php`.
2. Por `@fluxScripts` en `resources/views/components/layouts/app/sidebar.blade.php` (Livewire/Flux ya incluye Alpine).

Esa doble inicialización ejecutaba dos veces `x-init="init()"` del `toast-stack`, registrando listeners duplicados y renderizando el mismo toast de sesión dos veces.

## Corrección aplicada
- Se eliminó la carga de Alpine por CDN en `librerias-cdn`.
- Se eliminó la carga duplicada de `@vite` en `librerias-cdn` (ya estaba en `partials.styles`).
- `partials/session-message.blade.php` quedó como puente legado sin render.
- Se agregó una guarda singleton en `window.uiToastStack` para prevenir doble inicialización futura.

## Criterio de prevención
- El stack oficial de notificaciones debe renderizarse solo en el layout global.
- No volver a inyectar Alpine por CDN cuando la app ya usa Livewire/Flux.
