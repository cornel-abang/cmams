#!/bin/sh

set -e

cd /var/www  

php artisan migrate --seed
php artisan cache:clear
php artisan config:cache
php artisan route:cache

exec "$@"