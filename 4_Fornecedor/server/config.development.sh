#!/bin/sh
cd /app
composer install
composer dump-autoload
php artisan migrate
php artisan db:seed