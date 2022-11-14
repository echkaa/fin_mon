***For install project execute next:***

> For PHPUnit:\
> ```cp -i phpunit.xml.dist phpunit.xml```

> For Auth (generate new keys):\
> ```php bin/console lexik:jwt:generate-keypair```
>
> or
>
> mkdir config/jwt
> ```openssl genrsa -out config/jwt/private.pem 4096``` \
> ```openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem```

> Generate migration  
> php bin/console doctrine:migrations:diff

> Set operations from monobank   
> bin/console mono-bank:operations:setting

> Fill coin list from Binance  
> bin/console binance:coin:list:fill

> Fill transactions user from Binance   
> bin/console binance:fill:user:wallet
