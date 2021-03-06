#!/bin/bash

composer install --no-suggest --prefer-dist --optimize-autoloader

mkdir config/jwt

openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

chown -R www-data:www-data var
chown -R www-data:www-data vendor

usermod --non-unique --uid 1000 www-data
groupmod --non-unique --gid 1000 www-data
chown -R www-data:www-data .

php bin/console doctrine:migrations:migrate
