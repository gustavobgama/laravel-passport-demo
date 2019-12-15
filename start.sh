#!/bin/sh
set -e

echo "===> Running composer install"
composer install --ansi

ENV_FILE=".env"
if [ ! -f $ENV_FILE ]; then
    echo "===> Generating configurations"
    cp ".env.example" $ENV_FILE

    echo "===> Generating application key"
    php artisan key:generate --ansi

    echo "===> Running migrations (with seed)"
    touch ./database/database.sqlite
    php artisan migrate --seed --ansi
fi

echo "===> Running migrations"
php artisan migrate --ansi

echo "===> Creating keys for passport (only for API)"
php artisan passport:keys --ansi || true

echo "===> Configuring storage permissions"
chown -R www-data:www-data ./storage

echo "===> Running the PHP server"
php -d variables_order=EGPCS -S 0.0.0.0:$1 -t ./public ./server.php