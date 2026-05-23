# Fumigaciones

Sistema web de gestión de fumigaciones para insumos biológicos agrícolas. Permite administrar el catálogo de productos biológicos, sus ingredientes activos, tipos de producto, unidades de medida, tipos de aplicación y la relación producto–biológico, con soporte para la definición de recetas y programación de aplicaciones. Diseñado para equipos técnicos que requieren trazabilidad y control sobre la formulación y planificación de insumos.

---

## Stack Tecnológico

| Capa | Tecnología | Versión |
|---|---|---|
| Lenguaje backend | PHP | ^8.1 |
| Framework backend | Laravel | ^10.10 |
| Autenticación API | Laravel Sanctum | ^3.3 |
| UI scaffolding | Laravel UI | ^4.4 |
| DataTables server-side | Yajra DataTables | ^10.11 |
| Framework frontend | Vue.js | ^3.4.21 |
| Compatibilidad Vue 2→3 | @vue/compat | ^3.4.21 |
| Enrutamiento SPA | Vue Router | ^4.2.5 |
| Validación de formularios | VeeValidate | ^4.12.6 |
| UI Admin Theme | AdminLTE | 3.2 |
| CSS Framework | Bootstrap | ^5.3.3 |
| Bundler / Dev Server | Vite | ^5.0.0 |
| Plugin Vite–Laravel | laravel-vite-plugin | ^1.0.0 |
| Base de datos | MySQL | 5.7+ / 8.0+ |
| Entorno local recomendado | XAMPP | 8.1+ |

> **Node.js requerido:** ≥ 18.x (recomendado 20 LTS).

---

## Arquitectura del Sistema

El proyecto sigue un patrón **SPA híbrida**:

- **Laravel** actúa como servidor de rutas RESTful y motor de autenticación. Sirve una única vista Blade (`HomeController`) que bootstrappea la aplicación Vue.
- **Vue 3** maneja toda la navegación del lado del cliente mediante Vue Router. Cada módulo funcional (productos, biológicos, ingredientes, etc.) tiene su propio directorio con componentes `index.vue`, `modal.vue` y `table.vue`.
- **Vite** compila y sirve los assets en desarrollo con HMR (Hot Module Replacement).

```
Browser ──► Laravel (Auth + REST) ──► Blade Shell
                                           │
                                      Vue 3 SPA
                                      ├── Vue Router
                                      ├── AdminLTE 3 Layout
                                      └── Módulos por entidad
```

---

## Requisitos Previos

- [XAMPP](https://www.apachefriends.org/) con PHP 8.1+ y MySQL activos
- [Composer](https://getcomposer.org/) instalado globalmente
- [Node.js](https://nodejs.org/) ≥ 18.x con npm

Verificar versiones instaladas:

```bash
php -v
composer --version
node -v
npm -v
```

---

## Instalación Local en XAMPP (Windows)

### 1. Clonar el repositorio

Abrir una terminal (CMD o Git Bash) y clonar dentro de la carpeta `htdocs` de XAMPP:

```bash
cd C:\xampp\htdocs
git clone <URL_DEL_REPOSITORIO> fumigaciones
cd fumigaciones
```

> Si no usas Git, copia manualmente la carpeta del proyecto en `C:\xampp\htdocs\fumigaciones`.

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias Node.js

```bash
npm install
```

### 4. Configurar el archivo de entorno

Copiar el archivo de ejemplo y abrirlo para editarlo:

```bash
copy .env.example .env
```

Editar `.env` con los datos de tu base de datos local en XAMPP (el usuario por defecto de XAMPP es `root` sin contraseña):

```dotenv
APP_NAME=Fumigaciones
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/fumigaciones/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fumigacion
DB_USERNAME=root
DB_PASSWORD=
```

> Asegúrate de crear la base de datos `fumigacion` en phpMyAdmin antes del siguiente paso.

### 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

Esto creará todas las tablas necesarias: `users`, `biologics`, `unit_measures`, `type_products`, `products`, `ingredient_actives`, `ingredient_active_x_products`, `type_applications`, `blanco_biolg_products` y `definition_recets`.

---

## Ejecución del Entorno de Desarrollo

El proyecto requiere **dos procesos corriendo en paralelo**: el servidor web de XAMPP (Apache + MySQL) y el servidor de desarrollo de Vite.

### Terminal 1 — Iniciar XAMPP

Abrir el Panel de Control de XAMPP y hacer clic en **Start** para los módulos **Apache** y **MySQL**.

### Terminal 2 — Servidor de desarrollo Vite (HMR)

```bash
cd C:\xampp\htdocs\fumigaciones
npm run dev
```

Vite iniciará en `http://localhost:5173` y proporcionará recarga en caliente de los assets.

### Acceder a la aplicación

Con XAMPP corriendo, acceder desde el navegador a:

```
http://localhost/fumigaciones/public
```

> **Alternativa con `php artisan serve`:** Si prefieres no configurar Apache, puedes usar el servidor integrado de Laravel. Sin embargo, para producción o acceso por VirtualHost se recomienda XAMPP/Apache.
>
> ```bash
> cd C:\xampp\htdocs\fumigaciones
> php artisan serve
> ```
> La aplicación estará disponible en `http://127.0.0.1:8000`. Vite debe seguir corriendo en paralelo en otra terminal.

---

## Compilar para Producción

Cuando el proyecto esté listo para desplegar, generar los assets optimizados con:

```bash
npm run build
```

Los archivos compilados se guardan en `public/build/`. En producción no es necesario tener Vite corriendo; Laravel los servirá directamente.

---

## Estructura de Módulos Frontend

| Ruta Vue | Módulo |
|---|---|
| `/programacion` | Programación de aplicaciones |
| `/products` | Gestión de productos |
| `/blancoBiol` | Biológicos (blancos) |
| `/unidadaMed` | Unidades de medida |
| `/tipo_product` | Tipos de producto |
| `/type_application` | Tipos de aplicación |
| `/ingrediente_activo` | Ingredientes activos |
| `/ingrediente_activo_product` | Ingrediente activo × Producto |
| `/blanco_biologico_x_product` | Biológico × Producto |
| `/definition_recet` | Definición de recetas |

---

## Comandos Útiles

```bash
# Limpiar caché de configuración y vistas
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Revertir y volver a ejecutar migraciones (¡destruye datos!)
php artisan migrate:fresh

# Ver rutas registradas
php artisan route:list

# Consola interactiva de Laravel
php artisan tinker
```

---

## Notas de Seguridad

- Todas las rutas de recursos (`/products_table`, `/biologic_table`, etc.) están protegidas con el middleware `auth`.
- La autenticación se gestiona mediante Laravel UI (sesiones con cookies).
- No exponer el archivo `.env` en repositorios públicos. El archivo `.env.example` sirve como plantilla sin credenciales.

---

## Licencia

MIT
