# Seeders - Notas y Solución de Problemas

## Problema con Faker en Producción

### El Error

Cuando intentamos hacer `php artisan migrate:refresh --seed` en el servidor de producción, nos salió este error:

```
In UserFactory.php line 27:
  Call to undefined function Database\Factories\fake()
```

Y luego cuando intentamos usar `$this->faker`:

```
In UserFactory.php line 28:
  Call to a member function name() on null
```

### ¿Por qué pasó esto?

Después de investigar, descubrimos que **Faker solo está disponible en desarrollo**, no en producción. Si revisas el `composer.json`, verás que Faker está en `require-dev`:

```json
"require-dev": {
    "fakerphp/faker": "^1.23",
    ...
}
```

Esto significa que cuando hacemos `composer install --no-dev` en producción (que es lo correcto para optimizar), Faker no se instala.

### Intentos de solución que NO funcionaron

1. **Usar `fake()` directamente** - No funcionó porque la función global `fake()` depende de que Faker esté instalado.

2. **Usar `$this->faker`** - Tampoco funcionó porque Laravel no puede crear la instancia de Faker si el paquete no está instalado.

3. **Usar `\Faker\Factory::create()`** - Falló con "Class 'Faker\Factory' not found" porque, de nuevo, Faker no está en producción.

### La Solución

La solución fue **eliminar completamente la dependencia de Faker** en el `UserFactory.php` y usar valores estáticos simples:

```php
public function definition(): array
{
    return [
        'name' => 'Test User',
        'email' => 'test' . uniqid() . '@example.com',
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'two_factor_confirmed_at' => null,
    ];
}
```

**¿Por qué funciona?**

Porque cuando llamamos `User::factory()->create([...])` en los seeders, los valores que pasamos **sobrescriben** los valores por defecto del factory. Entonces no importa que el factory tenga valores estáticos, porque siempre usamos valores específicos en nuestros seeders.

### Lecciones aprendidas

1. **Los Factories deben funcionar sin dependencias de desarrollo** si los vas a usar en seeders de producción.

2. **Alternativa 1**: Si necesitas datos random en producción, usa funciones nativas de PHP:
   - `uniqid()` para IDs únicos
   - `rand()` para números aleatorios
   - `Str::random()` para strings aleatorios

3. **Alternativa 2**: Si realmente necesitas Faker en producción, muévelo de `require-dev` a `require` en el `composer.json` (pero esto no es recomendado porque aumenta el tamaño de tu aplicación innecesariamente).

4. **Mejor práctica**: Los seeders de producción deberían tener datos específicos y predefinidos, no aleatorios. Los datos aleatorios son más útiles en desarrollo/testing.

### Cómo verificar si Faker está disponible

Puedes verificar si Faker está instalado con:

```bash
php artisan tinker --execute="echo class_exists('Faker\Generator') ? 'Faker disponible' : 'Faker NO disponible';"
```

### Pasos para resolver problemas similares en el futuro

1. **Identifica el error**: ¿Dice "Call to undefined function" o "Class not found"?

2. **Revisa las dependencias**: Verifica si la clase/función está en `require-dev` en el `composer.json`

3. **Pregúntate**: ¿Esto se va a ejecutar en producción? Si sí, no puede depender de paquetes de `require-dev`

4. **Busca alternativas nativas**: PHP y Laravel tienen muchas funciones built-in que no requieren dependencias externas

5. **Testea en un ambiente similar a producción**: Si puedes, prueba con `composer install --no-dev` antes de deployar

## Otros Seeders Corregidos

### RoleSeeder.php

También tuvimos que cambiar de `createOrUpdate` a `firstOrCreate` porque:

- `createOrUpdate` no existe en el modelo Role de Spatie
- `firstOrCreate` busca el registro primero, y si existe lo devuelve sin crear uno nuevo
- Esto evita el error "RoleAlreadyExists" cuando corremos los seeders múltiples veces

```php
// ❌ Mal - Este método no existe
$role = Role::createOrUpdate(['name' => 'Admin']);

// ✅ Bien - firstOrCreate es el método correcto
$role = Role::firstOrCreate(['name' => 'Admin']);
```

---

**Última actualización**: Febrero 2026
**Autor**: Equipo de desarrollo SCR
