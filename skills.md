# skills.md — Habilidades del Frontend

Este documento describe las **skills** (habilidades/capacidades) del sistema desde la perspectiva del frontend Vue. Cada skill es una unidad funcional compuesta por un conjunto de componentes Vue que trabajan en conjunto para realizar una operación completa de cara al usuario.

---

## Arquitectura de Componentes

Todos los módulos siguen el mismo patrón de tres capas. Entender este patrón es suficiente para leer o extender cualquier módulo del sistema:

```
index.vue  ←──── Orquestador (no tiene lógica propia, coordina Table y Modal)
   │
   ├── table.vue  ←── Presentación de datos (DataTables + llamada GET a la API)
   │
   └── modal.vue  ←── Lógica de escritura (crear, editar, eliminar + SweetAlert2)
```

**Comunicación entre capas:**

```
table.vue  ──emit('edit', rowData)──►  index.vue  ──llama modal.value.editProduct(data)──►  modal.vue
table.vue  ──emit('delete', rowData)─► index.vue  ──llama modal.value.onDeleteProduct(data)► modal.vue
modal.vue  ──emit('create')──────────► index.vue  ──llama table.value.getXxx()──────────────► table.vue
```

El `index.vue` actúa como bus de eventos: recibe eventos del hijo `Table`, los redirige al hijo `Modal`, y cuando `Modal` confirma un cambio, fuerza una recarga del `Table`.

---

## Stack de Librerías Frontend

| Librería | Versión | Uso en el proyecto |
|---|---|---|
| Vue 3 + `@vue/compat` | ^3.4.21 | Framework base; usa `<script setup>` (Composition API) en todos los módulos |
| Vue Router 4 | ^4.2.5 | Navegación SPA con `createWebHistory` |
| Bootstrap Vue (BootstrapVue) | ^2.x (compat) | Componentes UI: `<b-modal>`, `<b-button>`, `<b-container>`, `<b-row>` |
| DataTables.net-vue3 | — | Tablas con paginación, búsqueda y soporte responsive; registrado globalmente como `<DataTables>` |
| datatables.net-responsive | — | Plugin de responsividad para DataTables |
| SweetAlert2 | — | Confirmaciones de eliminación y toasts de feedback |
| VeeValidate 4 | ^4.12.6 | Formularios reactivos con `<Form>` y `<Field>` |
| vue3-select2-component | — | Selector avanzado con búsqueda, registrado globalmente como `<Select2>` |
| Axios | — | Cliente HTTP para consumir la API REST de Laravel |
| AdminLTE 3 | — | Tema de layout: sidebar, navbar y estilos de tarjetas |
| Font Awesome 5 | — | Iconografía (vía build assets: `fa-solid`, `fa-regular`, `fa-brands`) |

---

## Componentes Globales y de Layout

### `App.vue` — Raíz de la SPA

Componente raíz montado en `#app`. Ensambla el layout completo de AdminLTE:

```
App.vue
 ├── <SideBar/>   → menú de navegación lateral
 ├── <NavBar/>    → barra superior
 └── <router-view/> → aquí se renderizan los módulos según la ruta activa
```

### `SideBar.vue`

Sidebar de AdminLTE con `<router-link>` hacia todos los módulos. Muestra íconos de Font Awesome por cada sección. El ítem activo recibe las clases `text-white active` via `active-class`.

**Ítems de navegación registrados:**

| Ícono FA | Texto | Ruta destino |
|---|---|---|
| `fa-shopping-cart` | Productos | `ProductsIndex` |
| `fa-feather` | Blanco Biologico | `BlancoBioIndex` |
| `fa-grip-lines` | Unidad Medida | `UnidadMediIndex` |
| `fa-quidditch` | Tipo de producto | `TipoProductIndex` |
| `fa-quidditch` | Ingrediente activo | `IngredienteActivoIndex` |
| `fa-quidditch` | Ingredientes x producto | `IngredienteActivoProductIndex` |
| `fa-spray-can` | Tipo de aplicacion | `TipoAplicacionIndex` |

> Nota: el ítem "Blanco Biologico x producto" existe en el código comentado (`<!-- ... -->`). Está pendiente de habilitarse en el sidebar.

### `NavBar.vue`

Barra superior con el logo de la aplicación (texto "FUMIGACION"), enlace a `programIndex`, menú desplegable "RECETAS" (con subniveles aún sin conectar a rutas reales), y widgets de notificaciones/mensajes (actualmente con datos estáticos de placeholder).

---

## Skills por Módulo

---

### SKILL-01 · Gestión de Productos

**Ruta SPA:** `/products` (nombre: `ProductsIndex`)
**Archivos:** `resources/js/products/`
**API endpoint:** `/products_table`

**Capacidades:**
- Listar productos en tabla con columnas: Nombre, Valor unitario, Dosis, Categoría + acciones.
- Crear producto mediante modal con formulario de 7 campos: nombre, dosis, valor unitario, código, categoría, unidad de medida (Select2 cargado desde `/unit_meansure`) y tipo de producto (Select2 cargado desde `/type_product_table`).
- Editar producto: pre-popula el modal y dispara `PUT /products_table/{id}`. En modo edición, los Select2 se sincronizan con los valores actuales del registro via jQuery (`.val().trigger('change')`).
- Eliminar producto con confirmación SweetAlert2 estilizada antes de ejecutar `DELETE`.
- Contador de productos visibles en el encabezado de la tarjeta (`N productos registrados`).
- Botón de navegación a `BlancoBiolProductIndex` desde el encabezado del módulo.

**Campos del formulario modal:**

| Field name | Label | Tipo de control |
|---|---|---|
| `name` | Nombre | Input texto |
| `dosis` | Dosis | Input numérico |
| `valueUnit` | Valor unitario | Input numérico |
| `code` | Codigo | Input numérico |
| `Categor` | Categoria | Input texto |
| `id_unidad_medida` | Unidad medida | Select2 (carga async) |
| `id_tipo_producto` | Tipo producto | Select2 (carga async) |

---

### SKILL-02 · Gestión de Blancos Biológicos

**Ruta SPA:** `/blancoBiol` (nombre: `BlancoBioIndex`)
**Archivos:** `resources/js/biologic/`
**API endpoint:** `/biologic_table`

**Capacidades:**
- Listar blancos biológicos en tabla con columna: Descripción + acciones.
- Crear, editar y eliminar con modal de campo único (`description`).
- Confirmación de eliminación con SweetAlert2.
- Contador de registros en encabezado.

> Este módulo es el más simple del sistema y sirve como referencia canónica del patrón `index/table/modal`.

---

### SKILL-03 · Gestión de Unidades de Medida

**Ruta SPA:** `/unidadaMed` (nombre: `UnidadMediIndex`)
**Archivos:** `resources/js/unit_measure/`
**API endpoint:** `/unit_meansure`

**Capacidades:**
- CRUD completo de unidades de medida (ej. ml, g, L, kg).
- Formulario de campo único: `description`.
- Usado como fuente de datos (`onMounted`) por el modal de Productos (SKILL-01).

---

### SKILL-04 · Gestión de Tipos de Producto

**Ruta SPA:** `/tipo_product` (nombre: `TipoProductIndex`)
**Archivos:** `resources/js/type_product/`
**API endpoint:** `/type_product_table`

**Capacidades:**
- CRUD completo de tipos de producto (ej. fungicida, insecticida).
- Formulario de campo único: `description`.
- Usado como fuente de datos (`onMounted`) por el modal de Productos (SKILL-01).

---

### SKILL-05 · Gestión de Tipos de Aplicación

**Ruta SPA:** `/type_application` (nombre: `TipoAplicacionIndex`)
**Archivos:** `resources/js/type_application/`
**API endpoint:** `/type_application_table`

**Capacidades:**
- CRUD completo de tipos de aplicación (ej. foliar, drench, fertirriego).
- Formulario de campo único: `description`.

---

### SKILL-06 · Gestión de Ingredientes Activos

**Ruta SPA:** `/ingrediente_activo` (nombre: `IngredienteActivoIndex`)
**Archivos:** `resources/js/ingredient_active/`
**API endpoint:** `/ingredient_active_table`

**Capacidades:**
- CRUD completo de ingredientes activos (principios activos biológicos o químicos).
- Formulario de campo único: `description`.
- Usado como fuente de datos por SKILL-07.

---

### SKILL-07 · Relación Ingrediente Activo × Producto

**Ruta SPA:** `/ingrediente_activo_product` (nombre: `IngredienteActivoProductIndex`)
**Archivos:** `resources/js/ingredient_active_X_product/`
**API endpoint:** `/ingredient_activex_product_table`

**Capacidades:**
- Listar relaciones existentes en tabla con columnas: Producto, Ingrediente activo + acciones.
- Crear una relación: selección de un producto (Select2, carga desde `/products_table`) y selección múltiple de ingredientes activos (Select2 múltiple, carga desde `/ingredient_active_table`). El envío hace un bulk insert de N filas.
- Eliminar una relación específica.
- El modal recibe props `options` y `value` para compatibilidad con Select2 externo.

**Payload de creación:**
```json
{
  "id_producto": 5,
  "ingredients": [1, 3, 7]
}
```

---

### SKILL-08 · Relación Blanco Biológico × Producto

**Ruta SPA:** `/blanco_biologico_x_product` (nombre: `BlancoBiolProductIndex`)
**Archivos:** `resources/js/blanco_biolog_x_product/`
**API endpoint:** `/biolog_x_product`

**Capacidades:**
- Listar relaciones existentes en tabla con columnas: Producto, Blanco biológico + acciones.
- Crear una relación: selección de producto (Select2) y selección múltiple de blancos biológicos (Select2 múltiple). Bulk insert.
- Eliminar una relación.

**Payload de creación:**
```json
{
  "id_producto": 3,
  "blanco_biol_x_producto": [2, 5]
}
```

> Esta skill es el espejo de SKILL-07, pero para la entidad `blanco_biologico`. El componente modal omite `onUpdateproduc`, por lo que la edición no está implementada.

---

### SKILL-09 · Programación *(placeholder)*

**Ruta SPA:** `/programacion` (nombre: `programIndex`)
**Archivos:** `resources/js/programacion/`

**Estado:** ⚠️ En desarrollo. El `index.vue` renderiza únicamente el texto `"HOLA PROYECCIONES"` y un componente `Table` con datos estáticos vacíos. La tabla tiene columnas definidas (`name`, `position`, `office`, `extn`, `start_date`, `salary`) que corresponden al dataset de ejemplo de DataTables, no al dominio real.

**Responsabilidad prevista:** Vista principal de planificación y visualización de proyecciones de aplicación de insumos.

---

## Patrón de Feedback al Usuario

Todos los módulos implementados utilizan el mismo sistema de notificaciones visual:

**Confirmación de eliminación** — SweetAlert2 modal con botones Bootstrap estilizados:
```
¿Esta seguro de eliminar [entidad]?
[Confirmar]  [Cancel]
```

**Toast de operación exitosa** — SweetAlert2 toast en esquina superior derecha, auto-cierra en 3 segundos, con barra de progreso y fondo de color según tipo:

| Tipo de operación | Ícono | Color del toast |
|---|---|---|
| Creación | `info` | Azul claro `#3fc3ee` |
| Actualización | `success` | Verde `#a5dc86` |
| Eliminación | `success` | Verde `#a5dc86` |
| Error | `error` | Rojo `#f27474` |

---

## Configuración Global de DataTables

Todos los componentes `table.vue` comparten la misma configuración de DataTables:

```javascript
{
  dom: `<'row col-sm-12'<'col-sm-4 col-md-3'l><'col-sm-2 col-md-9'f>/><'col-sm-12'tr>
        <'row col-sm-12'<'col-5 'i><'col-9 d-flex justify-content-end'p>/>`,
  responsive: true,
  autoWidth: false,
  language: {
    url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
  },
  pageLength: 5
}
```

Puntos clave:
- **Idioma en español** cargado desde CDN externo. Si no hay conexión a internet, la tabla cae en inglés.
- **5 filas por página** como valor por defecto.
- **Responsive activado** via plugin `datatables.net-responsive`.
- El layout `dom` personalizado alinea el selector de filas a la izquierda, la búsqueda al centro y la paginación a la derecha, usando clases Bootstrap 5.

---

## Rutas Vue Router Registradas

| Path | Nombre | Componente | Estado |
|---|---|---|---|
| `/menu` | `example` | `ExampleComponent` | Placeholder |
| `/home` | `homeDashboard` | `NavBar` | ⚠️ Apunta a NavBar directamente |
| `/programacion` | `programIndex` | `programacion/index` | En desarrollo |
| `/products` | `ProductsIndex` | `products/index` | ✅ Completo |
| `/blancoBiol` | `BlancoBioIndex` | `biologic/index` | ✅ Completo |
| `/unidadaMed` | `UnidadMediIndex` | `unit_measure/index` | ✅ Completo |
| `/tipo_product` | `TipoProductIndex` | `type_product/index` | ✅ Completo |
| `/ingrediente_activo` | `IngredienteActivoIndex` | `ingredient_active/index` | ✅ Completo |
| `/ingrediente_activo_product` | `IngredienteActivoProductIndex` | `ingredient_active_X_product/index` | ✅ Completo |
| `/type_application` | `TipoAplicacionIndex` | `type_application/index` | ✅ Completo |
| `/blanco_biologico_x_product` | `BlancoBiolProductIndex` | `blanco_biolog_x_product/index` | ✅ Completo |
| `/definition_recet` | `BlancoBiolProductIndex` | `blanco_biolog_x_product/index` | ⚠️ Nombre de ruta duplicado, apunta al módulo equivocado |

> **Bug de rutas:** `/definition_recet` y `/blanco_biologico_x_product` tienen el mismo `name: "BlancoBiolProductIndex"`. Vue Router solo mantendrá la última definición; la ruta de definición de recetas no es accesible por nombre.

---

## Deuda Técnica Frontend Identificada

| # | Descripción | Archivos afectados |
|---|---|---|
| 1 | Sentencias `debugger` en producción dentro de los `.catch()` y `.finally()` de Axios | Todos los `table.vue` y `modal.vue` |
| 2 | `console.log` de desarrollo sin remover (`'sssasdas'`) | `products/index.vue`, `biologic/index.vue` |
| 3 | Nombre de ruta duplicado `BlancoBiolProductIndex` | `routes.js` |
| 4 | `programacion/table.vue` usa columnas del dataset demo de DataTables (name, position, office) en lugar de columnas del dominio | `programacion/table.vue` |
| 5 | `SideBar.vue` tiene el nombre de usuario hardcodeado ("Alexander Pierce") y la imagen de avatar es un GIF estático | `components/SideBar.vue` |
| 6 | `NavBar.vue` tiene contadores de notificaciones y mensajes hardcodeados (15, 3) | `components/NavBar.vue` |
| 7 | El idioma de DataTables se carga desde CDN externo; si falla la conexión, la UI queda en inglés | Todos los `table.vue` |
| 8 | La ruta `/definition_recet` apunta al componente `BlancoBiolXProduct` en lugar del componente correcto | `routes.js` |
