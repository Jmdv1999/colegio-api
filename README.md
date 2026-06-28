# Sistema de Gestión Escolar - API & Frontend

## Descripción
Sistema para la gestión de alumnos, asignaturas, profesores y calificaciones desarrollado con Laravel.

## Requisitos 
- PHP 8.x
- Composer
- MySQL

## Instalación
1. Clonar el repositorio:
   `git clone https://github.com/Jmdv1999/colegio-api.git`
2. Instalar dependencias:
   `composer install`
3. Copiar el archivo de variables entorno:
   `cp .env.example .env`
4. Configurar las credenciales de base de datos en el archivo `.env`.
5. Generar la clave de la aplicación:
   `php artisan key:generate`
6. Ejecutar migraciones y seeders:
   `php artisan migrate --seed`
7. Iniciar el servidor:
   `php artisan serve`

## Funcionalidades
- CRUD completo para Alumnos, Asignaturas, Profesores y Calificaciones.
- Validación de datos en cada endpoint.
- Manejo de excepciones centralizado.
- Navegabilidad mediante [Livewire/Blade].