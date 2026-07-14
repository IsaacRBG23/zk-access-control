# ZK Access Control

Sistema de control de acceso basado en roles y permisos, desarrollado como evaluación técnica utilizando Laravel, Vue, Inertia, TypeScript y MySQL.

El proyecto permite administrar usuarios, roles y permisos mediante una interfaz web, manteniendo la autorización protegida desde el backend y adaptando la navegación según los permisos del usuario autenticado.

## Convención de idioma

La documentación funcional de este repositorio se presenta en español para facilitar su revisión.

El código fuente, nombres de clases, métodos, rutas, ramas, commits y pull requests se mantuvieron en inglés siguiendo convenciones ampliamente utilizadas en desarrollo de software y buscando mantener consistencia técnica en todo el proyecto.

## Tecnologías utilizadas

### Backend

* PHP 8.5
* Laravel 13
* Laravel Fortify
* Inertia
* MySQL 8
* PHPUnit

### Frontend

* Vue 3
* TypeScript
* Tailwind CSS
* Vite
* Lucide Icons

### Herramientas

* Composer
* npm
* Git
* GitHub
* GitHub Actions
* Laravel Wayfinder

## Funcionalidades

* Autenticación de usuarios.
* Registro de usuarios.
* Verificación de correo electrónico.
* Actualización de perfil y contraseña.
* Administración de usuarios.
* Administración de roles.
* Administración de permisos.
* Asignación de roles a usuarios.
* Asignación de permisos a roles.
* Middleware personalizado de autorización.
* Rutas protegidas mediante permisos.
* Navegación visible según los permisos del usuario.
* Dashboard con métricas de usuarios, roles y permisos.
* Protección contra la eliminación del usuario autenticado.
* Protección de roles predeterminados.
* Protección de permisos asociados a roles.
* Pruebas unitarias y de integración.

## Modelo de autorización

La autorización se basa en la siguiente relación:

```text
User -> Roles -> Permissions
```

Un usuario puede tener uno o varios roles, y cada rol puede tener uno o varios permisos.

Los permisos utilizan una convención basada en recurso y acción:

```text
users.view
users.create
users.update
users.delete

roles.view
roles.create
roles.update
roles.delete

permissions.view
permissions.create
permissions.update
permissions.delete
```

El middleware personalizado verifica que el usuario autenticado posea el permiso requerido antes de permitir el acceso a una ruta.

Ejemplo:

```php
Route::get('users', [UserController::class, 'index'])
    ->middleware('permission:users.view')
    ->name('users.index');
```

La visibilidad de los enlaces en el frontend mejora la experiencia del usuario, pero no sustituye la autorización del backend.

## Roles iniciales

El sistema crea los siguientes roles mediante seeders:

* `Administrator`
* `Manager`
* `User`

El rol `Administrator` tiene acceso a las funciones administrativas disponibles.

## Requisitos

Antes de instalar el proyecto es necesario contar con:

* PHP 8.5 o superior.
* Composer 2.
* Node.js 24 LTS o compatible.
* npm 11 o compatible.
* MySQL 8.
* Git.

## Instalación

Clonar el repositorio:

```bash
git clone https://github.com/IsaacRBG23/zk-access-control.git
cd zk-access-control
```

Instalar las dependencias de PHP:

```bash
composer install
```

Instalar las dependencias de JavaScript:

```bash
npm install
```

Crear el archivo de entorno:

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

### Linux o macOS

```bash
cp .env.example .env
```

Generar la llave de la aplicación:

```bash
php artisan key:generate
```

## Configuración de la base de datos

Crear una base de datos MySQL:

```sql
CREATE DATABASE zk_access_control
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
```

Configurar las credenciales locales dentro de `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zk_access_control
DB_USERNAME=root
DB_PASSWORD=
```

El archivo `.env` no debe ser agregado al repositorio.

Ejecutar las migraciones y seeders:

```bash
php artisan migrate:fresh --seed
```

## Ejecución local

Iniciar Laravel:

```bash
php artisan serve
```

En otra terminal, iniciar Vite:

```bash
npm run dev
```

La aplicación estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

## Usuario de demostración

Los seeders crean el siguiente usuario administrativo para pruebas locales:

```text
Email: admin@zk-access-control.test
Password: Password123!
```

Estas credenciales son únicamente para un entorno local o de demostración y deben modificarse en cualquier entorno real.

## Compilación de producción

Para generar los recursos optimizados:

```bash
npm run build
```

Los archivos generados dentro de `public/build` no se versionan.

## Pruebas

Ejecutar toda la suite:

```bash
php artisan test
```

Ejecutar pruebas específicas:

```bash
php artisan test --filter=PermissionMiddlewareTest
php artisan test --filter=UserManagementTest
php artisan test --filter=RoleManagementTest
php artisan test --filter=PermissionManagementTest
php artisan test --filter=DashboardTest
```

Estado esperado de la suite al finalizar la evaluación:

```text
46 passed
3 skipped
```

Las pruebas omitidas corresponden a funcionalidades de autenticación de dos factores de Laravel Fortify que no están habilitadas en este proyecto.

## Estructura principal

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
└── Models/

database/
├── migrations/
└── seeders/

resources/js/
├── components/
├── layouts/
├── pages/
├── routes/
└── types/

tests/
├── Feature/
└── Unit/
```

## Flujo de trabajo con Git

El proyecto se desarrolló mediante un flujo basado en las siguientes ramas:

```text
master
develop
feature/*
release/*
```

Proceso utilizado:

1. Crear una rama `feature/*` desde `develop`.
2. Implementar una funcionalidad específica.
3. Ejecutar pruebas y compilación.
4. Crear un commit descriptivo.
5. Subir la rama a GitHub.
6. Abrir un pull request hacia `develop`.
7. Revisar y fusionar el pull request.
8. Eliminar la rama de funcionalidad.
9. Preparar una rama de release.
10. Fusionar la versión estable hacia `master`.

Ejemplos de ramas utilizadas:

```text
feature/project-foundation
feature/access-control-schema
feature/permission-middleware
feature/user-management
feature/role-management
feature/permission-management
feature/navigation-and-dashboard
feature/documentation-and-polish
```

## Validaciones recomendadas

Antes de crear un pull request:

```bash
php artisan test
npm run build
git status
```

Antes de una entrega final:

```bash
composer install
npm ci
php artisan migrate:fresh --seed
php artisan test
npm run build
```

## Seguridad

* `.env` no se encuentra versionado.
* No se incluyen contraseñas reales ni secretos.
* `vendor` y `node_modules` no se incluyen en Git.
* Los recursos generados de producción no se versionan.
* Las rutas administrativas están protegidas desde el backend.
* Los permisos no dependen únicamente de la visibilidad de la interfaz.
* Las contraseñas se almacenan utilizando el sistema de hashing de Laravel.
* Las entradas se validan mediante Form Requests.
* Los usuarios sin autorización reciben una respuesta HTTP `403`.

## Decisiones técnicas

* Se utilizó una relación de muchos a muchos entre usuarios y roles.
* Se utilizó una relación de muchos a muchos entre roles y permisos.
* La autorización se centralizó mediante un middleware personalizado.
* La validación se separó mediante Form Requests.
* La interfaz utiliza Inertia para conectar Laravel y Vue sin construir una API independiente.
* TypeScript se utilizó para mejorar el tipado del frontend.
* La navegación se genera según los permisos compartidos mediante Inertia.
* El backend continúa siendo la fuente real de autorización.
* Se agregaron pruebas de integración para los flujos principales.

## Estado del proyecto

El proyecto incluye los módulos principales solicitados para un sistema de control de acceso:

* Usuarios.
* Roles.
* Permisos.
* Autorización.
* Navegación protegida.
* Dashboard.
* Pruebas automatizadas.
* Datos iniciales mediante seeders.

## Autor

Desarrollado por Isaac Rodrigo Becerril González como evaluación técnica.
