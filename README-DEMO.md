# MNZone — Demo presencial

Esta copia está preparada para enseñar el proyecto en una entrevista técnica sin depender de Internet.

## Entorno

- XAMPP
- Apache
- MariaDB / MySQL
- PHP
- Composer

## Puesta en marcha

1. Copiar `MNZone_Demo_Preparado` dentro de `C:\xampp\htdocs\`.
2. Arrancar Apache y MySQL desde XAMPP.
3. En phpMyAdmin, crear/importar la base de datos `mnzone_db` usando `mysql/mnzone_db.sql`.
4. Comprobar que la configuración local utiliza `localhost`, usuario `root`, contraseña vacía y base de datos `mnzone_db`.
5. Ejecutar `composer install` desde la carpeta del proyecto si las dependencias no están instaladas.
6. Abrir `http://localhost/MNZone_Demo_Preparado/`.

## Cuenta de demostración

Administrador:

- Usuario: `Admin`
- Contraseña: `DemoMNZone!2026`

Usuario normal:

- Usuario: `DemoUser`
- Contraseña: `DemoJaime!2026`

## Recorrido recomendado (5–7 minutos)

### 1. Presentación

Explicar que MNZone es una plataforma web de gestión para un centro gaming desarrollada como TFG de DAW.

### 2. Usuario

Mostrar:

- Inicio de sesión
- Servicios y equipamiento
- Tienda
- Reserva
- Perfil

### 3. Administración

Entrar con la cuenta de administrador y mostrar:

- Gestión de socios
- Gestión de servicios/productos
- Gestión de noticias
- Gestión de reservas
- Gestión de contenido

### 4. Parte técnica

Abrir VS Code y enseñar como mínimo:

- `php/esencial/conexion.php`
- `php/socios/register.php`
- `php/reservas/`
- `php/tienda/api_crud/`
- `mysql/mnzone_db.sql`
- `python/`

### 5. Explicación técnica

Preparar especialmente estas preguntas:

- Cómo se conecta PHP con MySQL.
- Cómo funciona la sesión de usuario.
- Cómo se valida la contraseña.
- Cómo se relacionan las tablas.
- Qué papel tiene la API interna.
- Qué operaciones CRUD implementaste.
- Qué hace la aplicación Python de contadores.

## Preparación antes de una visita

- Probar Apache + MySQL.
- Abrir la aplicación y verificar login.
- Verificar que existe la cuenta de administrador.
- Confirmar que la tienda y reservas cargan correctamente.
- Tener VS Code abierto con el proyecto.
- Tener preparado el SQL y la explicación de la base de datos.
- Llevar una copia en un pendrive.


### Refresco visual V4

Incluye una mejora específica del estado de sesión del encabezado y del carrito de la tienda, con estado vacío, mejor jerarquía, contraste y responsive.
