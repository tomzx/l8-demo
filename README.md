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
* Configure `.env` according to your environment
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
