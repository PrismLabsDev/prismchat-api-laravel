# Prism Chat Server Laravel

This repository contains the Prism Chat Server application written in Laravel. We plan to have the first version available written in Laravel and eventually create the application using GO.

## Setup Dev Environment

The following describes how to setup and run the application dev environment.

### Clone the repository

``` bash
git clone git@github.com:jwoodrow99/prismchat-server-laravel.git
```

### Run Development Docker

``` bash
docker-compose -f docker-compose.dev.yml up -d --build
# docker-compose -f docker-compose.dev.yml up -d --scale prism-php=2 --no-recreate
# docker-compose -f docker-compose.dev.yml up -d --scale prism-php=1 --no-recreate
docker-compose -f docker-compose.dev.yml down

# Clear all docker data
docker system prune -a
docker volume prune
```

### Copy example.env

``` bash
cp .env.example .env
```

## Generate Keys

``` bash
docker exec prism-php php artisan key:generate --show # Copy key to APP_KEY in .env
docker exec prism-php php artisan key:jwt # Copy COMBINED key to KEYPAIR_JWT in .env
docker exec prism-php php artisan key:auth # Copy COMBINED key to KEYPAIR_AUTH in .env
```

### Install dependencies and run migrations

``` bash
docker exec prism-php composer install
docker exec prism-php php artisan migrate:fresh --seed
```

## Connections

You can access the running application on port 80 of your local system, this can be done by simply going to [http://localhost:8080/](http://localhost:8080/)
