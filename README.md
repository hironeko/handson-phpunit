### set up

```shell
composer install
docker-compose up -d
php artisan migrate --env=testing
```


## check first phpunit

```
composer test-run
```
