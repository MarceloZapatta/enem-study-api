FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative


FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN docker-php-ext-install opcache

COPY --from=vendor --chown=www-data:www-data /app /var/www/html
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p /var/www/html/database/data \
    && chown -R www-data:www-data storage bootstrap/cache database/data

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
