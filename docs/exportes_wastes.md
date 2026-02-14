# Exportes WASTES (PDF y Excel)

## Resumen
- Módulo: `WASTES` (RESOL/RESPEL).
- Exportación PDF: `spatie/laravel-pdf` + Browsershot + Puppeteer.
- Exportación Excel: `maatwebsite/excel` (XLSX).
- Los reportes excluyen `evidence_image` por diseño de query (`select` explícito).

## Requisitos en Windows + Laragon
1. Tener Node.js y npm instalados.
2. Tener dependencia `puppeteer` instalada en el proyecto (`node_modules` local).
3. Configurar binarios en `.env` si hay múltiples instalaciones de Node:

```dotenv
LARAVEL_PDF_NODE_BINARY=C:\laragon\bin\nodejs\node-v22\node.exe
LARAVEL_PDF_NPM_BINARY=C:\laragon\bin\nodejs\node-v22\npm.cmd
LARAVEL_PDF_NODE_MODULES_PATH=C:\laragon\www\Sistema_Clasificacion_Residuos_Solidos\node_modules
LARAVEL_PDF_CHROME_PATH=
```

Notas:
- `LARAVEL_PDF_CHROME_PATH` solo es necesario si Chromium/Chrome no se detecta automáticamente.
- La configuración base está en `config/laravel-pdf.php`.

## Verificación rápida
1. Ejecutar `php artisan route:list` y validar que no fallen rutas del módulo.
2. Abrir listado RESOL y exportar PDF global.
3. Abrir listado RESPEL y exportar PDF global.
4. Probar exportación individual PDF desde el menú por fila.
5. Repetir los pasos 2-4 para Excel (`.xlsx`).

## Troubleshooting
### Error `Cannot find module 'puppeteer'`
- Verificar que exista `node_modules/puppeteer`.
- Verificar que `LARAVEL_PDF_NODE_MODULES_PATH` apunte a la carpeta correcta.
- Verificar que `LARAVEL_PDF_NODE_BINARY` corresponda al Node usado por Laragon (web runtime).

### Múltiples Node en PATH (fnm + Laragon + Program Files)
- Definir explícitamente:
  - `LARAVEL_PDF_NODE_BINARY`
  - `LARAVEL_PDF_NPM_BINARY`
  - `LARAVEL_PDF_NODE_MODULES_PATH`
- Limpiar caché de configuración si aplica:
  - `php artisan config:clear`

### Validación 422 en exportación personalizada
- El backend exige:
  - `range_type=custom`
  - `start_date` y `end_date`
  - Sin fechas futuras
  - `start_date <= end_date`
  - Existencia de registros en el rango/unidad (`entry_date`)
- Mensaje esperado sin datos:
  - `No hay registros en el rango seleccionado.`
