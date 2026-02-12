# 🔒 GUÍA DE SISTEMA DE PERMISOS - SCR

## Tabla de Contenidos
1. [Instalación y Configuración](#instalación-y-configuración)
2. [Permisos por Rol](#permisos-por-rol)
3. [Uso en Vistas (Blade)](#uso-en-vistas-blade)
4. [Uso en Controladores](#uso-en-controladores)
5. [Comandos Útiles](#comandos-útiles)
6. [Troubleshooting](#troubleshooting)

---

## Instalación y Configuración

### 1. Ejecutar las migraciones y seeders

```bash
# Limpiar base de datos y volver a crear todo
php artisan migrate:fresh --seed

# O solo ejecutar los seeders (si ya tienes la BD)
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
```

### 2. Limpiar caché de permisos

```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:cache-reset
```

---

## Permisos por Rol

| Módulo | Acción | Gestora Ambiental | Líder Ambiental | Aprendiz |
|--------|--------|------------------|-----------------|----------|
| **Áreas** | Ver (index/show) | ✅ | ✅ | ✅ |
| | Crear | ✅ | ✅ | ❌ |
| | Editar | ✅ | ✅ | ❌ |
| | Eliminar | ✅ | ❌ | ❌ |
| **Unidades Productivas** | Ver | ✅ | ✅ | ✅ |
| | Crear | ✅ | ✅ | ❌ |
| | Editar | ✅ | ✅ | ❌ |
| | Eliminar | ✅ | ❌ | ❌ |
| **Residuos (RESOL/RESPEL)** | Ver | ✅ | ✅ | ✅ |
| | Crear | ✅ | ✅ | ❌ |
| | Editar | ✅ | ✅ | ❌ |
| | Eliminar | ✅ | ❌ | ❌ |
| | Ver Reportes | ✅ | ✅ | ✅ |
| **Gestión de Roles** | Asignar roles | ✅ | ❌ | ❌ |

**Total de permisos creados:** 45+

---

## Uso en Vistas (Blade)

### 1. Verificar si el usuario tiene un permiso específico

```blade
@can('areas.create')
    <a href="{{ route('areas.create') }}" class="btn btn-primary">
        Crear Nueva Área
    </a>
@endcan
```

### 2. Verificar si el usuario tiene un rol

```blade
@role('Gestora Ambiental')
    <button class="btn btn-danger">
        Eliminar Todo
    </button>
@endrole
```

### 3. Verificar si el usuario tiene alguno de varios roles

```blade
@hasanyrole('Gestora Ambiental|Lider Ambiental')
    <a href="{{ route('wastes.create', $unit) }}" class="btn btn-success">
        Crear Residuo
    </a>
@endhasanyrole
```

### 4. Verificar si el usuario tiene todos los roles especificados

```blade
@hasallroles('Gestora Ambiental|Lider Ambiental')
    <!-- Contenido -->
@endhasallroles
```

### 5. Ocultar botón de eliminar (solo para Gestora)

```blade
<td>
    @can('areas.edit')
        <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">
            Editar
        </a>
    @endcan

    @can('areas.destroy')
        <form action="{{ route('areas.destroy', $area) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro?')">
                Eliminar
            </button>
        </form>
    @endcan
</td>
```

### 6. Mostrar contenido diferente según rol

```blade
@role('Aprendiz')
    <div class="alert alert-info">
        Solo puedes ver esta información, no puedes editarla.
    </div>
@else
    <div class="alert alert-success">
        Tienes permisos para editar esta información.
    </div>
@endrole
```

### 7. Usar en DataTables (acciones condicionadas)

```blade
{{-- En la columna de acciones de una tabla --}}
<div class="btn-group">
    <a href="{{ route('areas.show', $area) }}" class="btn btn-sm btn-info">
        Ver
    </a>

    @can('areas.edit')
        <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">
            Editar
        </a>
    @endcan

    @can('areas.destroy')
        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $area->id }})">
            Eliminar
        </button>
    @endcan
</div>
```

### 8. Combinar múltiples permisos

```blade
@canany(['areas.edit', 'areas.destroy'])
    <div class="card-footer">
        <h5>Acciones Administrativas</h5>

        @can('areas.edit')
            <a href="{{ route('areas.edit', $area) }}" class="btn btn-warning">
                Editar
            </a>
        @endcan

        @can('areas.destroy')
            <form action="{{ route('areas.destroy', $area) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Eliminar
                </button>
            </form>
        @endcan
    </div>
@endcanany
```

---

## Uso en Controladores

### 1. Verificar permiso en el constructor

```php
class AreaController extends Controller
{
    public function __construct()
    {
        // Proteger todos los métodos
        $this->middleware('permission:areas.index')->only('index');
        $this->middleware('permission:areas.create')->only(['create', 'store']);
        $this->middleware('permission:areas.edit')->only(['edit', 'update']);
        $this->middleware('permission:areas.destroy')->only('destroy');
    }
}
```

### 2. Verificar permiso en un método específico

```php
public function destroy(Area $area)
{
    // Verificar manualmente si el usuario tiene el permiso
    if (!auth()->user()->can('areas.destroy')) {
        abort(403, 'No tienes permiso para eliminar áreas.');
    }

    $area->delete();

    return redirect()->route('areas.index')
        ->with('success', 'Área eliminada correctamente.');
}
```

### 3. Usar Gate::authorize

```php
use Illuminate\Support\Facades\Gate;

public function update(Request $request, Area $area)
{
    // Lanza 403 si no tiene permiso
    Gate::authorize('areas.update');

    $area->update($request->validated());

    return redirect()->route('areas.index');
}
```

### 4. Verificar rol del usuario

```php
public function store(Request $request)
{
    if (auth()->user()->hasRole('Aprendiz')) {
        return redirect()->back()->withErrors([
            'error' => 'Los aprendices no pueden crear áreas.'
        ]);
    }

    // Crear área...
}
```

### 5. Verificar múltiples permisos

```php
public function complexAction()
{
    $user = auth()->user();

    if ($user->can('areas.create') && $user->can('areas.edit')) {
        // Usuario puede crear y editar
    }

    if ($user->hasAnyPermission(['areas.create', 'areas.edit', 'areas.destroy'])) {
        // Usuario tiene al menos uno de estos permisos
    }
}
```

---

## Comandos Útiles

### Ver todos los permisos de un usuario

```bash
php artisan tinker
```

```php
$user = User::find(1);
$user->getAllPermissions(); // Todos los permisos (directos + de roles)
$user->permissions;         // Solo permisos directos
$user->roles;               // Roles del usuario
```

### Ver permisos de un rol

```php
$role = Role::findByName('Lider Ambiental');
$role->permissions;
```

### Asignar permiso directo a un usuario (temporal)

```php
$user = User::find(5);
$user->givePermissionTo('areas.destroy'); // Ahora puede eliminar áreas aunque sea Aprendiz
```

### Revocar permiso directo

```php
$user = User::find(5);
$user->revokePermissionTo('areas.destroy');
```

### Limpiar caché de permisos

```bash
php artisan permission:cache-reset
```

### Listar todos los permisos

```bash
php artisan tinker
```

```php
Permission::all()->pluck('name');
```

---

## Troubleshooting

### Problema: "User does not have the right permissions"

**Solución 1:** Limpiar caché

```bash
php artisan permission:cache-reset
php artisan cache:clear
```

**Solución 2:** Verificar que el usuario tenga el permiso

```bash
php artisan tinker
```

```php
$user = User::find(1);
$user->hasPermissionTo('areas.create'); // Debe retornar true
```

**Solución 3:** Re-ejecutar el PermissionSeeder

```bash
php artisan db:seed --class=PermissionSeeder
```

---

### Problema: Botones aparecen pero al hacer clic da 403

**Causa:** El botón no está protegido con `@can`, pero la ruta sí tiene middleware.

**Solución:** Siempre usar `@can` en las vistas para ocultar botones:

```blade
{{-- MAL --}}
<a href="{{ route('areas.destroy', $area) }}" class="btn btn-danger">
    Eliminar
</a>

{{-- BIEN --}}
@can('areas.destroy')
    <a href="{{ route('areas.destroy', $area) }}" class="btn btn-danger">
        Eliminar
    </a>
@endcan
```

---

### Problema: Gestora Ambiental no puede acceder a gestión de roles

**Causa:** No se ejecutó el seeder correctamente.

**Solución:**

```bash
php artisan db:seed --class=PermissionSeeder
```

Verificar en tinker:

```php
$gestora = Role::findByName('Gestora Ambiental');
$gestora->permissions->count(); // Debe ser 45+
```

---

## Ejemplos Prácticos Completos

### Ejemplo 1: Vista de listado de áreas con acciones

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Áreas</h1>

        @can('areas.create')
            <a href="{{ route('areas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Área
            </a>
        @endcan
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
            <tr>
                <td>{{ $area->id }}</td>
                <td>{{ $area->name }}</td>
                <td>{{ $area->description }}</td>
                <td>
                    <a href="{{ route('areas.show', $area) }}" class="btn btn-sm btn-info">
                        Ver
                    </a>

                    @can('areas.edit')
                        <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                    @endcan

                    @can('areas.destroy')
                        <form action="{{ route('areas.destroy', $area) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
```

### Ejemplo 2: Dashboard con información según rol

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    @role('Gestora Ambiental')
        <div class="alert alert-success">
            <h4>Bienvenida, Gestora Ambiental</h4>
            <p>Tienes acceso total al sistema. Puedes crear, editar y eliminar todos los registros.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Áreas</h5>
                        <p class="display-4">{{ $totalAreas }}</p>
                        <a href="{{ route('areas.index') }}" class="btn btn-primary">Ver todas</a>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('Lider Ambiental')
        <div class="alert alert-info">
            <h4>Bienvenido, Líder Ambiental</h4>
            <p>Puedes ver, crear y editar registros. No puedes eliminar.</p>
        </div>
    @endrole

    @role('Aprendiz')
        <div class="alert alert-warning">
            <h4>Bienvenido, Aprendiz</h4>
            <p>Solo puedes consultar información. No puedes crear, editar ni eliminar.</p>
        </div>
    @endrole
</div>
@endsection
```

---

## Estructura de Permisos Creados

### Módulo Areas (8 permisos)
- `areas.index`
- `areas.create`
- `areas.store`
- `areas.show`
- `areas.edit`
- `areas.update`
- `areas.destroy`
- `areas.destroy.confirm`

### Módulo Productive Units (7 permisos)
- `productive-units.index`
- `productive-units.create`
- `productive-units.store`
- `productive-units.show`
- `productive-units.edit`
- `productive-units.update`
- `productive-units.destroy`

### Módulo Wastes (27 permisos)
- Navegación: `wastes.navigator`
- RESOL: `wastes.{index,create,store,edit,update,destroy}`
- RESPEL: `hazardou-wastes.{index,create,store,edit,update,destroy}`
- Reportes: `wastes.report.{resol,respel}`
- Outlets RESOL: `waste-outlets.{index,store,update,destroy}`
- Outlets RESPEL: `hazardou-waste-outlets.{index,store,update,destroy}`

### Módulo Roles (6 permisos)
- `roles.index`
- `roles.create`
- `roles.store`
- `roles.edit`
- `roles.update`
- `roles.destroy`

**Total:** 48 permisos

---

## Contacto y Soporte

Si tienes dudas o problemas con el sistema de permisos, consulta esta guía o contacta al equipo de desarrollo.

✅ **Sistema implementado y funcionando correctamente**
