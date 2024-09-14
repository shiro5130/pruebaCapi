# Proyecto Laravel de Contactos

Este proyecto es una API REST construida con Laravel que gestiona contactos, teléfonos, correos electrónicos y direcciones.

## Requisitos

- PHP >= 7.4
- Composer
- MySQL o MariaDB
- Node.js (para la gestión de dependencias front-end si es necesario)

## Instalación

### 1. Clonar el repositorio

Primero, clona el repositorio a tu máquina local:

```bash
git clone https://github.com/shiro5130/pruebaCapi.git

```

composer install

copiar el env de env.example cambiando las variables de entrono:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pruebaCapi
DB_USERNAME=root
DB_PASSWORD=


php artisan key:generate

php artisan migrate

php artisan db:seed
