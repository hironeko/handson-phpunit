### set up

```shell
composer install
docker-compose up -d
php artisan migrate --seed --env=testing
```


## check first phpunit

```
composer test-run
```
