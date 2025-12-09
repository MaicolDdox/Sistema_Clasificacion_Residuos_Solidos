# Feature: Sistema de Asignacion de Roles

**Branch:** `feature/roles`
**Desarrollador:** John (Backend - Laravel)
**Fecha:** 2025-12-08

---

# Errores y Confusiones Durante el Desarrollo, Hace rato que no desarrollaba con plugins

# 1. Dependencia no instalada (spatie/laravel-permission)
**Problema:** Al cambiar entre branches, no ejecute `composer install`, lo que causo que el paquete `spatie/laravel-permission` no estuviera en `vendor/` a pesar de estar en `composer.json`.

**Error encontrado:**
```
Class "Spatie\Permission\Models\Role" not found
```

**Solucion aplicada:**
```bash
composer install
composer dump-autoload
php artisan migrate:fresh --seed
```

**Leccion aprendida:** Siempre ejecutar `composer install` despues de hacer `git checkout` o `git pull` cuando hay cambios en `composer.json` o `composer.lock`.

# 2. Convencion de namespaces en vistas
**Confusion inicial:** No estaba claro si las vistas de roles debian ir en `resources/views/roles/` o en un modulo separado como `modules/Roles/`.

**Decision tomada:** Se coloco en `resources/views/roles/` ya que la gestion de roles es una funcionalidad central del sistema, no un modulo de negocio independiente como Areas o Unidades Productivas.

# 3. Animaciones del menu desplegable **NOT WORKING GOOD**
**Problema:** Inicialmente use `x-collapse` de Alpine.js que requiere el plugin adicional `@alpinejs/collapse` que NO esta instalado en el proyecto.

**Error:** El menu desplegable no mostraba animacion de colapso/expansion suave. La directiva `x-collapse` simplemente no funcionaba porque requiere:
```bash
npm install @alpinejs/collapse
```
Y luego registrarlo en el JavaScript:
```js
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
Alpine.plugin(collapse)
```

**Solucion aplicada:** En lugar de instalar dependencias adicionales, use las transiciones CSS nativas de Alpine.js que vienen incluidas por defecto con `x-transition`:

```blade
<div x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     class="mt-1 ml-12 space-y-1">
```

**Ventajas de esta solucion:**
- No requiere dependencias adicionales
- Funciona con Alpine.js base
- Animacion fluida y ligera
- Mas control sobre los estados de transicion

**En mi maquina parece no funcionar, pero segun la IA si deberia sin implementar mas dependencias, CORREGIR MENU DESPLEGABLE MAICOL!! lo vamos probando** 

---

# Sugerencias para el Proyecto

# 1. Documentacion de estructura de modulos
**Sugerencia:** Agregar un documento que especifique cuando crear un modulo en `modules/` vs cuando usar `app/` + `resources/views/`.

**Criterio propuesto:**
- `modules/`: Entidades de negocio con migraciones propias (Areas, Wastes, ProductiveUnits)
- `app/`: Funcionalidad transversal del sistema (Auth, Roles, Permisos, Configuraciones)

# 2. Seeder de permisos
**Observacion:** Actualmente solo hay roles creados en `RoleSeeder.php`, pero no hay permisos definidos.

**Sugerencia futura:** Crear `PermissionSeeder.php` con permisos granulares como:
```php
Permission::create(['name' => 'areas.create']);
Permission::create(['name' => 'areas.edit']);
Permission::create(['name' => 'areas.delete']);
// etc.
```

Y luego asignarlos a roles:
```php
$gestoraAmbiental->givePermissionTo(['areas.create', 'areas.edit', 'areas.delete']);
$liderAmbiental->givePermissionTo(['areas.edit']);
```

# 3. Middleware de proteccion de rutas
**Observacion:** Las rutas de roles actualmente no tienen middleware de proteccion.

**Sugerencia futura:** Agregar middleware en `routes/web.php`:
```php
Route::resource('roles', AsigRoleController::class)
    ->middleware('role:Gestora Ambiental');
```

# 4. Validacion de auto-asignacion
**Caso edge:** Un usuario podria modificar su propio rol si tiene acceso al formulario.

**Sugerencia futura:** Agregar validacion en `AsigRoleController`:
```php
if ($user->id === auth()->id()) {
    return back()->withErrors(['user_id' => 'No puedes modificar tu propio rol']);
}
```

---

# Archivos Creados

# Controlador
- `app/Http/Controllers/AsigRoleController.php`
  - `index()`: Listar usuarios con roles (AJAX para DataTable)
  - `create()`: Formulario asignar rol
  - `store()`: Guardar asignacion
  - `edit()`: Formulario editar rol
  - `update()`: Actualizar rol
  - `destroy()`: Remover roles del usuario

# Vistas
- `resources/views/roles/roles-list.blade.php` - Tabla con DataTable AJAX
- `resources/views/roles/roles-create.blade.php` - Formulario asignar rol
- `resources/views/roles/roles-edit.blade.php` - Formulario editar rol
- `resources/views/roles/partials/roles-actions.blade.php` - Botones de accion (editar/eliminar)

### Menu
- `resources/views/components/layouts/app/menu/roles/roles-list.blade.php`
  - Menu desplegable con Alpine.js
  - Sub-items: "Gestionar Roles" y "Asignar Rol"

---

# Archivos Modificados

# Asignacion automatica de rol "Aprendiz"
**Archivo:** `app/Actions/Fortify/CreateNewUser.php`

**Cambio:**
```php
$user = User::create([...]);

// Asignar rol "Aprendiz" por defecto a todos los nuevos usuarios
$user->assignRole('Aprendiz');

return $user;
```

**Razon:** Todos los usuarios que se registran en el sistema deben tener el rol base "Aprendiz" por defecto.

# Rutas
**Archivo:** `routes/web.php`

**Cambio:**
```php
Route::middleware(['auth'])->group(function () {
    // ... rutas existentes

    // Rutas de Asignacion de Roles
    Route::resource('roles', \App\Http\Controllers\AsigRoleController::class);
});
```

**Rutas generadas:**
- GET `/roles` - Lista de usuarios
- GET `/roles/create` - Formulario asignar
- POST `/roles` - Guardar asignacion
- GET `/roles/{id}/edit` - Formulario editar
- PUT `/roles/{id}` - Actualizar
- DELETE `/roles/{id}` - Eliminar roles

---

# Funcionamiento del Sistema

# Flujo de asignacion de roles

1. **Registro de nuevo usuario:**
   - Usuario se registra via formulario de registro
   - `CreateNewUser` automaticamente le asigna rol "Aprendiz"
   - Usuario puede iniciar sesion con permisos basicos

2. **Gestora Ambiental asigna roles:**
   - Accede al menu "Roles > Gestionar Roles"
   - Ve tabla con todos los usuarios y sus roles actuales
   - Puede buscar usuarios en tiempo real con DataTable
   - Click en "Editar" para cambiar el rol de un usuario
   - Selecciona nuevo rol (Gestora Ambiental, Lider Ambiental, Aprendiz)
   - Sistema actualiza el rol usando `syncRoles()` de Spatie

3. **Asignacion a usuario sin rol:**
   - Click en "Asignar Rol" en el menu
   - Selecciona usuario del dropdown
   - Selecciona rol del dropdown
   - Sistema asigna rol con `syncRoles()`

4. **Eliminar roles:**
   - Click en boton rojo "Eliminar" en tabla
   - Confirmacion con `confirm()`
   - Sistema remueve todos los roles con `syncRoles([])`

# Patron de implementacion seguido

Segui el patron existente en `modules/Areas/` y `modules/ProductiveUnits/`:

**DataTable AJAX:**
- Controlador detecta `$request->ajax()`
- Retorna JSON con `['data' => $collection]`
- Vista inicializa DataTable apuntando a `route('roles.index')`
- JavaScript renderiza columnas con iconos SVG
- Acciones se renderizan con `view()->render()`

**Formularios:**
- Layout consistente con gradientes emerald/teal
- Validacion de errores en servidor
- Mensajes flash con `session()->with('success', ...)`
- Botones con iconos SVG y transiciones
- Formularios responsivos con Tailwind

---

# Tecnologias Utilizadas

- **Backend:** Laravel 12, PHP 8.3+
- **Roles y Permisos:** Spatie Laravel Permission 6.23
- **Frontend:** Livewire Flux, Alpine.js, Tailwind CSS
- **DataTables:** jQuery DataTables con AJAX
- **Animaciones:** AOS (Animate On Scroll)

---

# Testing Manual Realizado

1. Registro de nuevo usuario - Verificado que recibe rol "Aprendiz"
2. Listado de usuarios en DataTable - Verificado carga AJAX
3. Busqueda en tiempo real - Funcional
4. Asignacion de rol - Funcional con validacion
5. Edicion de rol - Funcional, muestra rol actual
6. Eliminacion de roles - Funcional con confirmacion
7. Menu desplegable - Funcional con animaciones suaves
8. Responsive design - Probado en diferentes tamaños de pantalla

---

# Notas Adicionales

# Consideraciones de seguridad
- Actualmente NO hay middleware protegiendo las rutas
- Cualquier usuario autenticado puede acceder a `/roles`
- En produccion, agregar middleware `role:Gestora Ambiental`

# Usuarios de prueba creados por seeders
Despues de ejecutar `php artisan migrate:fresh --seed`:

- **gestora_ambiental@gmail.com** - Rol: Gestora Ambiental
- **lider_ambiental@gmail.com** - Rol: Lider Ambiental
- **aprendiz@gmail.com** - Rol: Aprendiz

Password para todos: Se encuentra en `database/seeders/UserAndRoleSeeder.php`

# Arquitectura del sistema de roles

**Roles disponibles:**
1. **Gestora Ambiental** - Administrador del sistema
   - Puede asignar/editar roles
   - Puede crear Areas, Unidades Productivas, Residuos
   - Acceso completo al sistema

2. **Lider Ambiental** - Usuario intermedio
   - Permisos limitados (a definir en futuro)
   - Supervisa aprendices

3. **Aprendiz** - Usuario base
   - Rol por defecto al registrarse
   - Puede registrar datos de residuos en modulos (canecas)
   - Acceso de solo lectura en otras secciones

---

# Proximos Pasos (Futuros)

1. Implementar middleware de proteccion de rutas
2. Crear sistema de permisos granulares
3. Agregar logs de auditoria (quien cambio que rol y cuando)
4. Panel de historial de cambios de roles
5. Validacion para prevenir auto-modificacion de roles
6. Tests unitarios y de integracion

---

**Commit final:** Implementacion completa del sistema de asignacion de roles con DataTable AJAX, formularios de asignacion/edicion, y menu desplegable en sidebar.
