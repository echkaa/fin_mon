FROM php:8.1-fpm

RUN apt update -y && apt install -y --no-install-recommends \
    curl \
    libicu-dev \
    libzip-dev \
    unzip \
    libssl-dev \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN docker-php-ext-install pdo pdo_mysql zip \
    && pecl install igbinary redis \
    && docker-php-ext-enable igbinary \
    && docker-php-ext-enable redis

WORKDIR /var/www/kava_project
