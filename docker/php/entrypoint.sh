#!/bin/bash
set -e

until nc -z "${DB_HOST}" "${DB_PORT:-3306}"; do
    sleep 1
done

composer install --no-interaction --prefer-dist --optimize-autoloader

mkdir -p /var/www/html/var/cache \
         /var/www/html/var/compiled_templates \
         /var/www/html/var/logs

chown -R www-data:www-data /var/www/html/var

php /var/www/html/bin/migrate.php
php /var/www/html/bin/seed.php --if-empty

exec "$@"
