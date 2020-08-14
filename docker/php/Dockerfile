FROM php:7.1-fpm-alpine
RUN apk add --no-cache  icu-libs icu-dev libxml2-dev gettext
RUN docker-php-ext-install -j$(nproc) intl simplexml pdo pdo_mysql