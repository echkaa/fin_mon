#!/bin/bash

composer install --no-suggest --prefer-dist --optimize-autoloader

chown -R www-data:www-data var
chown -R www-data:www-data vendor

usermod --non-unique --uid 1000 www-data
groupmod --non-unique --gid 1000 www-data
chown -R www-data:www-data .

echo | php bin/console doctrine:migrations:diff
echo | php bin/console doctrine:migrations:migrate
php bin/console seed:load user

mkdir config/jwt
openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
