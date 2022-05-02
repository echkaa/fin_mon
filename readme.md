***For install project execute next:***

> For PHPUnit:\
> ```cp -i phpunit.xml.dist phpunit.xml```

> For Auth:\
> ```php bin/console lexik:jwt:generate-keypair```
>
> or
>
> ```openssl genrsa -out config/jwt/private.pem 4096``` \
> ```openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem```
