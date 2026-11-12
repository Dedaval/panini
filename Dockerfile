FROM php:8.5-apache

RUN apt-get update && apt-get install -y unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html