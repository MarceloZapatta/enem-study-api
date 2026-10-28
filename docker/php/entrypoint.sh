#!/bin/sh
set -e

touch "$DB_DATABASE"
# Bind-mounted from the host: keep it writable for both php-fpm (www-data) and the host user.
chmod 777 "$(dirname "$DB_DATABASE")"
chmod 666 "$DB_DATABASE"

php artisan migrate --force
php artisan config:cache
php artisan route:cache

exec "$@"
