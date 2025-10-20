# gestion-mascotas-API
Gestión CRUD de mascotas virtuales con API REST en Laravel 10 y cliente PHP/Guzzle y con autenticación de usuarios

## Características principales

### Server (Laravel API)
- Autenticación de usuarios con **Laravel Sanctum** (tokens API).
- **CRUD de mascotas**: listar, crear, modificar, eliminar.
- Migraciones y seeders incluidos para inicializar la base de datos.

**Rutas principales:**
- `POST /api/login` → Login y obtención de token.
- `POST /api/logout` → Logout de usuario autenticado.
- `GET /api/mascotasAMC` → Listar mascotas del usuario.
- `POST /api/mascotasAMC` → Crear mascota.
- `PUT /api/mascotasAMC/{id}` → Modificar mascota.
- `DELETE /api/mascotasAMC/{id}` → Eliminar mascota.

### Client (PHP + Guzzle)
- Scripts para interactuar con la API mediante HTTP:
  - `login.php` → Autenticación y almacenamiento del token en sesión.
  - `logout.php` → Cierre de sesión.
  - `mascotas.php` → Listado de mascotas del usuario autenticado.
- Scripts para **crear, modificar y eliminar mascotas** usando Guzzle.
- Manejo de **códigos de estado HTTP** (200, 401, 422, etc.).
- Comunicación exclusiva con la API vía **HTTP requests**.

## 🚀 Cómo probar el proyecto en local

### 🧩 Clonar el repositorio
```bash
git clone https://github.com/amescal/gestion-mascotas-API.git
cd gestion-mascotas-API
```
### ⚙️ Configuración del servidor (Laravel API)

1. Accede a la carpeta del servidor e instala las dependecias
```bash
cd server
composer install
```
2. Crea un archivo .env a partir del ejemplo
```bash
cp .env.example .env
```
3. Genera la clave de aplicación
```bash
php artisan key:generate
```
4. Configura la base de datos en .env editando las variables de entorno correspondientes (usuario, contraseña, nombre de la base de datos...)
5. Ejecuta las migraciones y el seeder
```bash
php artisan migrate:fresh
php artisan db:seeder AMCseeder
```
6. Inicia el servidor de desarrollo de Laravel para que el backend esté disponible en http://127.0.0.1:8080/
```bash
php artisan serve --port=8080
```

### ⚙️ Configuración del cliente (PHP + Guzzle)

1. Abre una nueva terminal, accede al directorio del cliente e instala las dependencias:
```bash
cd client
composer install
```
2. Ejecuta el cliente desde tu servidor local (por ejemplo, XAMPP) o usando el servidor de PHP:
```bash
php -S localhost:8080
```
3. El cliente estará disponible en http://localhost:8080/login.php

### Prueba 💻
1. Accede en el navegador a 👉 [http://localhost:8080/login.php](http://localhost:8080/login.php)
2. Inicia sesión con las credenciales del seeder
3. Explora las siguientes funcionalidades del cliente:  
 - Login / Logout  
 - Listado de mascotas  
 - Creación, edición y eliminación de mascotas
