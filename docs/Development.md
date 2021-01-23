# Development
The following documentation is aimed at developers who will be working on this project. It describes the steps to get your environment configured, how to run tests and how to run the code in a Docker container.

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

# API
You may test the API through your browser by heading to the root of the web application (e.g., http://localhost:8000). The documentation is generated using the [Swagger/OpenAPI specification](https://swagger.io/solutions/getting-started-with-oas/) in `resources/views/swagger/definition.blade.php`. For the moment this documentation is manually maintained to reflect the code but may be automatically generated in the future.

# Docker
To easily get started if you only have docker available, you can make use of the `Dockerfile` provided.

First start by building the image.
```bash
docker build -t l8-demo .
```
Copy `.env.testing` as `.env` and create an empty database file
```bash
cp .env.testing .env
touch database/database.sqlite
```
Then install the composer dependencies.
```bash
docker run --rm -v $(pwd):/srv/app l8-demo composer install
```
Migrate the database
```bash
docker run --rm -v $(pwd):/srv/app l8-demo php artisan migrate
```
Finally run the image, which will make a server available at http://localhost:8000 on your machine. Note that this server is not for production purposes and only for development.
```bash
docker run --rm -it -v $(pwd):/srv/app -p 8000:8000 l8-demo php artisan serve --host=0.0.0.0
```
