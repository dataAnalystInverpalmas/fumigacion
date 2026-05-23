# agents.md — Agentes del Sistema Proyecciones

Este documento describe los **agentes** del sistema: los controladores Laravel que actúan como responsables de cada dominio funcional. Cada controlador expone una API RESTful consumida por la SPA Vue, y tiene a su cargo la lógica de negocio, la auditoría de usuario y la respuesta en formato JSON para DataTables.

---

## Convenciones Globales

Todos los controladores de dominio comparten los siguientes comportamientos:

- **Autenticación obligatoria:** todas las rutas están protegidas con el middleware `auth` (sesión Laravel UI).
- **Auditoría de usuario:** en cada operación de escritura (`store`, `update`) se inyecta automáticamente el `id` del usuario autenticado (`Auth::user()->id`) en el campo `id_user` del registro.
- **Soft Deletes:** todos los modelos de dominio usan `SoftDeletes`. Los registros eliminados no se borran físicamente; se marca `deleted_at`.
- **Base de datos secundaria:** todos los modelos de dominio operan sobre la conexión `mysql2` (base de datos `DB_DATABASE_DB2`), separada de la base de datos de autenticación (`mysql`). Ver sección [Arquitectura de Datos](#arquitectura-de-datos).
- **Respuesta estándar de éxito:**
  ```json
  { "menssage": "success" }
  ```
  > Nota: el campo se llama `menssage` (con doble `s`) en todo el código base. Mantener esta ortografía al consumir la API desde el frontend.
- **Listados:** todos los métodos `index()` retornan datos serializados por **Yajra DataTables** (`datatables()->of($data)->toJson()`), compatibles con el componente `datatables.net-vue3` del frontend.

---

## Agentes de Dominio

### 1. `HomeController`

**Archivo:** `app/Http/Controllers/HomeController.php`
**Ruta:** `GET /{view?}` (catch-all)
**Responsabilidad:** Punto de entrada único de la SPA. Renderiza la vista Blade `layouts/initApp` que carga la aplicación Vue. No expone datos; actúa como shell de la SPA.

| Método | Descripción |
|---|---|
| `index()` | Retorna la vista `layouts/initApp`. Toda la navegación posterior ocurre en el cliente (Vue Router). |

**Notas:** El constructor aplica `$this->middleware('auth')`, por lo que cualquier ruta no autenticada redirige al login antes de que Vue cargue.

---

### 2. `BiologicController`

**Archivo:** `app/Http/Controllers/BiologicController.php`
**Ruta:** `Route::resource('/biologic_table', ...)`
**Modelo:** `Biologic` → tabla `blanco_biologico` (conexión `mysql2`)
**Responsabilidad:** CRUD completo sobre los **blancos biológicos**: organismos o patógenos objetivo a los que se dirige un producto (ej. hongos, bacterias, insectos).

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /biologic_table` | `index()` | Lista todos los biológicos ordenados por `created_at DESC`, paginados por DataTables. |
| `POST /biologic_table` | `store(Request)` | Crea un nuevo biológico. Campos: `description`, `id_user` (auto). |
| `PUT /biologic_table/{id}` | `update($id, Request)` | Actualiza la descripción del biológico por ID. |
| `DELETE /biologic_table/{id}` | `destroy($id)` | Soft-delete del biológico por ID. |

**Campos del modelo:**

| Campo | Tipo | Descripción |
|---|---|---|
| `description` | `string` | Nombre o descripción del blanco biológico |
| `id_user` | `integer` | ID del usuario que registró el dato |

---

### 3. `UnitMeasureController`

**Archivo:** `app/Http/Controllers/UnitMeasureController.php`
**Ruta:** `Route::resource('/unit_meansure', ...)`
**Modelo:** `UnitMeasure` → tabla `unidad_medida` (conexión `mysql2`)
**Responsabilidad:** Gestión del catálogo de **unidades de medida** utilizadas para dosificación de productos (ej. ml/L, g/kg, cc/ha).

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /unit_meansure` | `index()` | Lista todas las unidades de medida. |
| `POST /unit_meansure` | `store(Request)` | Crea una nueva unidad. Campos: `description`, `id_user` (auto). |
| `PUT /unit_meansure/{id}` | `update($id, Request)` | Actualiza la descripción. |
| `DELETE /unit_meansure/{id}` | `destroy($id)` | Soft-delete. |

> **Nota ortográfica en ruta:** la ruta está registrada como `/unit_meansure` (con `a` adicional). Usar esta URL exacta al hacer peticiones desde el frontend.

---

### 4. `TypeProductController`

**Archivo:** `app/Http/Controllers/TypeProductController.php`
**Ruta:** `Route::resource('/type_product_table', ...)`
**Modelo:** `TypeProduct` → tabla `tipo_producto` (conexión `mysql2`)
**Responsabilidad:** Catálogo de **tipos de producto** para clasificar insumos (ej. fungicida, insecticida, bactericida, biofertilizante).

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /type_product_table` | `index()` | Lista todos los tipos de producto. |
| `POST /type_product_table` | `store(Request)` | Crea un tipo. Campos: `description`, `id_user` (auto). |
| `PUT /type_product_table/{id}` | `update($id, Request)` | Actualiza la descripción. |
| `DELETE /type_product_table/{id}` | `destroy($id)` | Soft-delete. |

---

### 5. `TypeApplicationController`

**Archivo:** `app/Http/Controllers/TypeApplicationController.php`
**Ruta:** `Route::resource('/type_application_table', ...)`
**Modelo:** `TypeApplication` → tabla `tipo_aplicacion` (conexión `mysql2`)
**Responsabilidad:** Catálogo de **tipos de aplicación** que describe el método de aplicación de un producto (ej. foliar, drench, fertirriego).

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /type_application_table` | `index()` | Lista todos los tipos de aplicación. |
| `POST /type_application_table` | `store(Request)` | Crea un tipo. Campos recibidos del request: `name`, `dosis`, `valueUnit`, `code`, `Categor`, `undMed`. |
| `PUT /type_application_table/{id}` | `update($id, Request)` | Actualiza el registro. |
| `DELETE /type_application_table/{id}` | `destroy($id)` | Soft-delete. |

> **Advertencia de código:** el método `store()` mapea `id_user` al campo `undMed` del request (posible bug). Revisar al extender esta funcionalidad.

---

### 6. `ProductController`

**Archivo:** `app/Http/Controllers/ProductController.php`
**Ruta:** `Route::resource('/products_table', ...)` + `GET /products_tablel` (alias de input)
**Modelo:** `Product` → tabla `productos` (conexión `mysql2`)
**Responsabilidad:** Gestión del **catálogo maestro de productos** biológicos. Es la entidad central del sistema; los demás módulos referencian productos por `id_producto`.

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /products_table` | `index()` | Lista todos los productos con DataTables. |
| `POST /products_table` | `store(Request)` | Crea un producto completo. |
| `PUT /products_table/{id}` | `update($id, Request)` | Actualiza un producto. |
| `DELETE /products_table/{id}` | `destroy($id)` | Soft-delete. |

**Campos del modelo / payload de creación:**

| Campo request | Campo BD | Tipo | Descripción |
|---|---|---|---|
| `name` | `nombre` | `string` | Nombre comercial del producto |
| `dosis` | `dosis` | `decimal(10,2)` | Dosis de aplicación |
| `valueUnit` | `valor_unitario` | `decimal(10,2)` | Precio unitario |
| `code` | `codigo` | `integer` | Código interno |
| `Categor` | `categoria` | `string` | Categoría del producto |
| `id_unidad_medida` | `id_unidad_medida` | `integer` | FK → `unidad_medida` |
| `id_tipo_producto` | `id_tipo_producto` | `integer` | FK → `tipo_producto` |
| — | `id_user` | `integer` | Auto-inyectado desde sesión |

---

### 7. `IngredientActiveController`

**Archivo:** `app/Http/Controllers/IngredientActiveController.php`
**Ruta:** `Route::resource('/ingredient_active_table', ...)`
**Modelo:** `IngredientActive` → tabla `ingrediente_activo` (conexión `mysql2`)
**Responsabilidad:** Catálogo de **ingredientes activos** (principios activos químicos o biológicos) que componen los productos (ej. Bacillus subtilis, Trichoderma harzianum, Azadirachtin).

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /ingredient_active_table` | `index()` | Lista todos los ingredientes activos. |
| `POST /ingredient_active_table` | `store(Request)` | Crea un ingrediente. Campos: `description`, `id_user` (auto). |
| `PUT /ingredient_active_table/{id}` | `update($id, Request)` | Actualiza la descripción. |
| `DELETE /ingredient_active_table/{id}` | `destroy($id)` | Soft-delete. |

---

### 8. `IngredientActiveXProductController`

**Archivo:** `app/Http/Controllers/IngredientActiveXProductController.php`
**Ruta:** `Route::resource('/ingredient_activex_product_table', ...)`
**Modelo:** `IngredientActiveXProduct` → tabla `ingrediente_activo_x_product` (conexión `mysql2`)
**Responsabilidad:** Gestiona la relación **muchos-a-muchos** entre productos e ingredientes activos. Permite asignar múltiples ingredientes a un producto en una sola operación.

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /ingredient_activex_product_table` | `index()` | Lista todas las relaciones con JOIN a `productos` e `ingrediente_activo`. Retorna nombre del producto e ingrediente. |
| `POST /ingredient_activex_product_table` | `store(Request)` | Inserta múltiples registros en lote. Recibe un array `ingredients[]` y un `id_producto`. |
| `PUT /ingredient_activex_product_table/{id}` | `update($id, Request)` | Actualiza una relación específica. |
| `DELETE /ingredient_activex_product_table/{id}` | `destroy($id)` | Soft-delete de una relación. |

**Payload de creación (bulk insert):**
```json
{
  "id_producto": 5,
  "ingredients": [1, 3, 7]
}
```
El controlador itera el array `ingredients` e inserta una fila por cada elemento, asociándola al mismo `id_producto`.

---

### 9. `BlancoBiolProdController`

**Archivo:** `app/Http/Controllers/BlancoBiolProdController.php`
**Ruta:** `Route::resource('/biolog_x_product', ...)`
**Modelo:** `BlancoBiolProduct` → tabla `blanco_biolog_x_product` (conexión `mysql2`)
**Responsabilidad:** Gestiona la relación **muchos-a-muchos** entre productos y blancos biológicos. Indica contra qué organismos objetivo es efectivo cada producto.

| Método HTTP | Método PHP | Descripción |
|---|---|---|
| `GET /biolog_x_product` | `index()` | Lista relaciones con JOIN a `productos` y `blanco_biologico`. Retorna nombre del producto y descripción del blanco. |
| `POST /biolog_x_product` | `store(Request)` | Inserta múltiples relaciones en lote. Recibe un array `blanco_biol_x_producto[]` y un `id_producto`. |
| `DELETE /biolog_x_product/{id}` | `destroy($id)` | Soft-delete de una relación. |

**Payload de creación (bulk insert):**
```json
{
  "id_producto": 3,
  "blanco_biol_x_producto": [2, 5]
}
```

---

### 10. `DefinitionRecetController`

**Archivo:** `app/Http/Controllers/DefinitionRecetController.php`
**Modelo:** `DefinitionRecet` → tabla `definicion_receta` (conexión `mysql2`)
**Estado:** ⚠️ **En desarrollo** — todos los métodos están vacíos (`//`). La ruta no está registrada en `web.php`.

**Responsabilidad prevista:** Definición de recetas que combinan un tipo de aplicación con uno o más productos. Los campos del modelo (`id_tipo_aplicacion`, `id_user`) indican que será la entidad de nivel superior para planificar proyecciones.

---

### 11. `ProjectionController`

**Archivo:** `app/Http/Controllers/ProjectionController.php`
**Estado:** ⚠️ **Placeholder** — el método `index()` retorna la tabla `users` a través de DataTables. Implementación pendiente.

**Responsabilidad prevista:** Gestión de las **proyecciones** de aplicación (planificación de cuándo y en qué dosis se aplicarán los productos). Es el módulo que da nombre al sistema.

---

## Arquitectura de Datos

El sistema opera sobre **dos bases de datos MySQL simultáneas**:

| Conexión | Variable `.env` | Propósito |
|---|---|---|
| `mysql` (default) | `DB_DATABASE` | Autenticación: tablas `users`, `password_resets`, `personal_access_tokens`, `failed_jobs`. |
| `mysql2` | `DB_DATABASE_DB2` | Dominio de negocio: todas las tablas de catálogos, productos y relaciones. |

Las claves foráneas de `id_user` en las tablas de `mysql2` apuntan a `esquejes.users`, lo que indica que la base de datos de autenticación se llama `esquejes` en el entorno original de desarrollo. Ajustar la FK o las variables de entorno según el entorno local.

**Variables `.env` adicionales necesarias** (no presentes en `.env.example`):

```dotenv
DB_HOST_DB2=127.0.0.1
DB_PORT_DB2=3306
DB_DATABASE_DB2=proyecciones_dominio
DB_USERNAME_DB2=root
DB_PASSWORD_DB2=
```

---

## Diagrama de Dependencias entre Agentes

```
UnitMeasureController ──┐
TypeProductController ──┼──► ProductController
                        │         │
                        │         ├──► IngredientActiveXProductController ◄── IngredientActiveController
                        │         │
                        │         └──► BlancoBiolProdController ◄──────────── BiologicController
                        │
TypeApplicationController ──► DefinitionRecetController (pendiente)
                                        │
                                        └──► ProjectionController (pendiente)
```

---

## Estado de Implementación por Agente

| Agente | index | store | update | destroy | Estado |
|---|:---:|:---:|:---:|:---:|---|
| `HomeController` | ✅ | — | — | — | Completo |
| `BiologicController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `UnitMeasureController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `TypeProductController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `TypeApplicationController` | ✅ | ✅ | ✅ | ✅ | Completo (revisar bug en `store`) |
| `ProductController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `IngredientActiveController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `IngredientActiveXProductController` | ✅ | ✅ | ✅ | ✅ | Completo |
| `BlancoBiolProdController` | ✅ | ✅ | ⚠️ vacío | ✅ | Falta `update` |
| `DefinitionRecetController` | ⚠️ | ⚠️ | ⚠️ | ⚠️ | En desarrollo |
| `ProjectionController` | ⚠️ | — | — | — | Placeholder |
