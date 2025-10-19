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
