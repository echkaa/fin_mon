FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y libzip-dev

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/kava_project

RUN usermod --non-unique --uid 1000 www-data \
  && groupmod --non-unique --gid 1000 www-data \
  && chown -R www-data:www-data /var/www/kava_project

RUN chown www-data:www-data -R /var/www/kava_project