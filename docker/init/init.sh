#!/bin/bash

composer install --no-suggest --prefer-dist --optimize-autoloader

chown -R www-data:www-data var
chown -R www-data:www-data vendor

usermod --non-unique --uid 1000 www-data
groupmod --non-unique --gid 1000 www-data
chown -R www-data:www-data .

php bin/console doctrine:migrations:migrate
