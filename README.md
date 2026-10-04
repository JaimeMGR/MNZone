# MNZone

**Plataforma web full stack para la gestión integral de un centro gaming.**

MNZone es mi **Trabajo de Fin de Grado de Desarrollo de Aplicaciones Web (DAW)**. El proyecto centraliza la gestión de usuarios, reservas, productos, servicios, equipos y contenido de un centro gaming.

## Funcionalidades

### Usuarios

- Registro e inicio de sesión.
- Gestión del perfil.
- Consulta de servicios y equipos disponibles.
- Reserva de horas de juego.
- Compra de productos y servicios.
- Valoraciones y comentarios.
- Consulta de noticias y novedades.

### Administración

- Gestión de usuarios.
- Gestión de productos y servicios.
- Gestión de equipos.
- Gestión de reservas.
- Gestión de noticias y contenido.
- Operaciones CRUD sobre la información de la plataforma.

### Integraciones y lógica adicional

- Validación de formularios.
- Gestión de sesiones y permisos.
- API interna.
- Aplicación auxiliar desarrollada en Python para la gestión de tiempos de uso.
- Generación de documentos PDF mediante Dompdf.

## Tecnologías

| Área | Tecnologías |
|---|---|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP |
| Base de datos | MySQL |
| Aplicación auxiliar | Python |
| PDF | Dompdf |
| Dependencias | Composer |
| Control de versiones | Git / GitHub |

## Arquitectura y estructura

El proyecto sigue una arquitectura cliente-servidor con PHP como backend, MySQL como sistema de persistencia y JavaScript para la interacción en el cliente.

```text
MNZone/
├── css/                    # Estilos
├── imagenes/               # Recursos gráficos
├── js/                     # Lógica JavaScript
├── php/                    # Funcionalidades PHP
├── python/                 # Aplicación auxiliar
├── mysql/                  # Recursos relacionados con la BD
├── Files/                  # Recursos del proyecto
├── index.php               # Entrada principal
├── iniciar_sesion.php      # Autenticación
├── cerrar_sesion.php       # Cierre de sesión
├── utilidades.php          # Funciones auxiliares
├── composer.json           # Dependencias
└── composer.lock
```

## Aspectos técnicos destacados

El proyecto reúne varias piezas habituales de una aplicación web full stack:

- Autenticación y gestión de sesiones.
- Control de acceso según el tipo de usuario.
- Operaciones CRUD sobre distintas entidades.
- Persistencia de información en una base de datos relacional.
- Validación de datos recibidos desde formularios.
- Comunicación entre componentes mediante una API interna.
- Generación de documentos PDF.
- Integración de una aplicación auxiliar en Python.

## Objetivos del proyecto

- Diseñar y desarrollar una aplicación web completa desde cero.
- Aplicar una arquitectura cliente-servidor.
- Diseñar y utilizar una base de datos relacional.
- Gestionar usuarios, reservas, productos, servicios y equipos.
- Implementar autenticación, sesiones y validaciones.
- Integrar funcionalidades desarrolladas con diferentes tecnologías.

## Instalación

### Requisitos

- PHP
- MySQL
- Apache
- Composer

### Configuración

1. Clonar el repositorio.
2. Configurar el proyecto en un servidor Apache con PHP.
3. Crear la base de datos utilizando los scripts SQL incluidos en el repositorio.
4. Configurar las credenciales de conexión a MySQL.
5. Instalar las dependencias:

```bash
composer install
```

6. Iniciar la aplicación desde el servidor local.

## Proyecto académico

**Trabajo de Fin de Grado — CFGS Desarrollo de Aplicaciones Web (DAW).**

El proyecto se desarrolló como una aplicación completa, desde el diseño de la base de datos y la lógica backend hasta la interfaz y las funcionalidades de administración.
