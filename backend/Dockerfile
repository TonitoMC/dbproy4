FROM php:8.3.21

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .
RUN composer install

EXPOSE 8000
