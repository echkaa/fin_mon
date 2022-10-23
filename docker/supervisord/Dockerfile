FROM php:8.1-fpm

RUN apt-get update

RUN apt update -y && apt install -y --no-install-recommends \
    curl \
    gnupg2 \
    libaio1 \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    supervisor \
    unzip \
    watch \
    wget \
    libssl-dev \
    pkg-config \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-install sockets \
    && pecl install redis apcu \
    && docker-php-ext-enable pcntl \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable apcu


RUN apt-get install --no-install-recommends --no-install-suggests -y

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
