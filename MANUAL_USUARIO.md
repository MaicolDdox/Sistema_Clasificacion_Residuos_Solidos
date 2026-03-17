# 📘 MANUAL DE USUARIO - Sistema de Clasificación de Residuos Sólidos (SCR)

Bienvenido(a) al **Sistema de Clasificación de Residuos Sólidos (SCR)**. Este manual te guiará paso a paso para que puedas utilizar todas las funciones del sistema de manera fácil y rápida.

---

## 🌟 1. Introducción al Sistema

El sistema te permite gestionar y llevar un control estructurado de las **Áreas**, **Unidades Productivas** y los **Residuos Sólidos** generados, asegurando que cada usuario (según su rol) tenga acceso a la información que le corresponde.

### 🎭 Roles y Permisos (¿Qué puedo hacer?)
El sistema cuenta con tres perfiles principales:

| Rol | ¿Qué puede hacer? |
| :--- | :--- |
| 👑 **Gestora Ambiental** | Acceso **TOTAL**. Puede ver, crear, editar y eliminar registros en todos los módulos, además de administrar los roles de otros usuarios. |
| 🛡️ **Líder Ambiental** | Acceso **MEDIO**. Puede ver, crear y editar registros, pero **no puede eliminar** información crítica ni administrar roles. |
| 🎓 **Aprendiz** | Acceso **BÁSICO**. Solo puede **ver y consultar** información (modo lectura). No puede hacer cambios en el sistema. |

---

## 🚀 2. Primeros Pasos: Ingreso y Panel Principal

### 🔐 Iniciar Sesión
1. Ingresa a la URL del sistema.
2. Escribe tu **Correo Electrónico** y **Contraseña**.
3. Haz clic en el botón de **"Iniciar Sesión"**.

> [!TIP]
> Si olvidaste tu contraseña, comunícate con la **Gestora Ambiental** para que te asigne una nueva.

![Pantalla de Login](./docs/images/login-placeholder.png)
*(Aquí puedes visualizar la pantalla de inicio de sesión)*

### 📊 El Dashboard (Panel Principal)
Una vez dentro, verás el **Dashboard**, que cambia dependiendo de tu rol:
* Si eres **Gestora Ambiental**, verás estadísticas clave (total de áreas, unidades productivas, etc.).
* En el panel lateral izquierdo (Sidebar), encontrarás el **Menú Principal** para navegar por los diferentes módulos.

![Dashboard Principal](./docs/images/dashboard-placeholder.png)
*(Ejemplo de vista general en el Dashboard)*

---

## 🏢 3. Módulo de Áreas

Este módulo permite administrar las diferentes zonas físicas de la organización.

### 👀 Ver Áreas
* En el menú lateral, haz clic en **"Áreas"**.
* Verás una tabla dinámica con el ID, Nombre y Descripción de cada área.
* Puedes **buscar** un área específica usando el cuadro de búsqueda en la parte superior derecha de la tabla.

### ➕ Agregar un Área Nueva (Gestora o Líder)
1. En la vista de Áreas, haz clic en el botón azul **"NUEVA ÁREA"** (ubicado arriba a la derecha).
2. Completa el formulario con el nombre y la descripción.
3. Guarda los cambios.

### ✏️ Editar o Eliminar un Área
En la tabla de áreas, verás una columna de **"Acciones"** con botones de colores:
* 🟦 **Botón Celeste (Ver):** Muestra los detalles completos del área seleccionada.
* 🟨 **Botón Amarillo (Editar):** Permite cambiar el nombre o la descripción.
* 🟥 **Botón Rojo (Eliminar):** Borra el área (Solo disponible para la **Gestora Ambiental**).

![Módulo de Áreas](./docs/images/areas-placeholder.png)
*(Vista de la tabla dinámica de Áreas y sus botones de acciones)*

---

## 🏭 4. Módulo de Unidades Productivas

Las Unidades Productivas son subsecciones que pertenecen a un Área específica (ejemplo: "Laboratorio de Suelos" dentro del área "Ciencias").

### 🔄 Gestión de Unidades
El proceso es idéntico al módulo de Áreas:
1. Ve al menú **"Unidades Productivas"**.
2. Al **crear** una unidad nueva, el sistema te pedirá seleccionar a qué **Área** pertenece utilizando un menú desplegable.
3. Los botones de acción (Ver, Editar, Eliminar) funcionan exactamente igual según tu rol.

![Módulo de Unidades Productivas](./docs/images/unidades-placeholder.png)
*(Vista del módulo Unidades Productivas asociadas a sus Áreas)*

---

## ♻️ 5. Módulo de Residuos (RESOL y RESPEL)

Este es el módulo central del sistema, dividido en Residuos Sólidos Generales (RESOL) y Residuos Peligrosos (RESPEL).

### 📝 Registrar un Residuo (Gestora o Líder)
1. Ve al menú de **"Residuos"** y selecciona la categoría (RESOL o RESPEL).
2. Haz clic en **"Registrar Residuo"**.
3. Llena el formulario indicando el tipo de residuo, peso/cantidad, y la unidad productiva donde se generó.
4. Guarda el registro.

### 📊 Ver Reportes de Residuos
* Todos los roles (incluyendo **Aprendiz**) tienen acceso al historial y reportes de generación de residuos para hacer consultas o descargar información resumida si el sistema lo permite.

![Módulo de Residuos](./docs/images/residuos-placeholder.png)
*(Interfaz para el registro y consulta de Residuos)*

---

## 👥 6. Módulo de Gestión de Roles (Solo Gestora Ambiental)

Si eres **Gestora Ambiental**, tienes una opción exclusiva en el menú llamada **"Roles y Accesos"**.

### ⚙️ Asignar Permisos a Usuarios
1. Ve a **"Roles"** en el menú.
2. Selecciona a un usuario de la lista.
3. Cambia su rol principal (Gestora, Líder o Aprendiz) para actualizar sus permisos en todo el sistema.

> [!WARNING]
> Ten cuidado al asignar el rol de Gestora Ambiental a otra persona, ya que tendrá los mismos privilegios totales que tú, incluyendo la capacidad de eliminar información y cambiar roles.

---

## 💡 7. Consejos y Solución de Problemas (Troubleshooting)

* **No veo los botones de "Editar" o "Eliminar":** Esto se debe a que tu rol actual no te da permisos para realizar esas acciones (común si eres Aprendiz o Líder intentando eliminar).
* **El sistema va lento al cargar las tablas:** No te preocupes, las tablas están optimizadas para cargar mediante "AJAX". Si tarda, verifica tu conexión a internet o recarga la página.
* **Aparece un mensaje de error "No tienes permiso (403)":** Estás intentando acceder a una página restringida para tu rol. Si crees que es un error, contacta a la Gestora Ambiental.

✅ **¡Estás listo(a) para usar el Sistema de Clasificación de Residuos Sólidos!**
