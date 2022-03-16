FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip\
    git\
    curl\
    unzip

RUN pecl install xdebug \
   && docker-php-ext-enable xdebug


RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
