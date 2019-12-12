#!/bin/sh
set -e

echo "===> Generating configurations"
ENV_FILE=".env"
if [ ! -f $ENV_FILE ]; then
    cp ".env.example" $ENV_FILE
fi

echo "===> Running composer install"
composer install

echo "===> Running migrations"
touch ./database/database.sqlite
php artisan migrate --seed || true

echo "===> Creating keys for passport (only for API)"
php artisan passport:keys || true

echo "===> Configuring storage permissions"
chown -R www-data:www-data ./storage

echo "===> Running the PHP server"
php artisan serve --host=0.0.0.0 --port=$1