## Requisitos
* Framework: Laravel 10
* PHP 8.1
* Javascript
* CSS
* MySQL


## Instalación
Clonar el repositorio https://github.com/juansueldo/broobe-challenge.git

## Instalar dependecias de php
composer install

## Instalar dependecias de javascript
npm install

## Configuracion archivo .env
Ingresar las siguientes variables en tu archivo .env: 
* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306 
* DB_DATABASE=nombre_de_tu_base_de_datos
* DB_USERNAME=tu_usuario
* DB_PASSWORD=tu_contraseña
* GOOGLE_API_KEY=api_key

## Migrar la base de datos
php artisan migrate

## Ejecutar seeders
 php artisan db:seed
 
## Ejecutar la aplicacion
* npm run dev 
* php artisan serve
