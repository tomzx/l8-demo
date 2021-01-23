# l8-demo
A small laravel application for the purpose of demonstrating its REST API capabilities.

## Requirements
* [PHP 8+](https://www.php.net/)
* [Composer](https://getcomposer.org/)

## Getting started
* Clone the project 
```bash
git clone git@github.com:tomzx/l8-demo.git
```
* Install the PHP dependencies using composer
```bash
php composer.phar install
```
* Configure `.env` according to your environment (you may have to copy .env.example to get started)
  * Locally you may want to use `sqlite` as your `DB_CONNECTION` for simplicity. Make sure to create an empty `database/database.sqlite` file before migrating.
* Migrate the database
```bash
php artisan migrate
```
* Either configure your server to serve the `public` directory or run `php artisan serve`, which will start a server on `http://localhost:8000`.

# Tests
You can run the tests using `PHPUnit`
```bash
vendor/bin/phpunit
```

# Docker
To easily get started if you only have docker available, you can make use of the `Dockerfile` provided.

First start by building the image.
```
docker build -t l8-demo .
```
Copy `.env.testing` as `.env` and create an empty database file
```
cp .env.testing .env
touch database/database.sqlite
```
Then install the composer dependencies.
```
docker run --rm -v $(pwd):/srv/app l8-demo composer install
```
Migrate the database
```
docker run --rm -v $(pwd):/srv/app l8-demo php artisan migrate
```
Finally run the image, which will make a server available at http://localhost:8000 on your machine. Note that this server is not for production purposes and only for development.
```
docker run --rm -it -v $(pwd):/srv/app -p 8000:8000 l8-demo php artisan serve --host=0.0.0.0
```
