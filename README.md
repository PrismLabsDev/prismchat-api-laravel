# Prism Chat Server Laravel

This repository contains the Prism Chat Server application written in Laravel. We plan to have the first version avaliable written in Laravel and eventually create the application using GO.

## Setup Dev Environment

The following describes how to setup and run the application dev environment.

### Clone the repository

``` bash
git clone git@github.com:jwoodrow99/prismchat-server-laravel.git
```

### Run Development Docker

``` bash
docker-compose -f docker-compose.dev.yml up -d --build
docker-compose -f docker-compose.dev.yml down
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

You can access the running application on port 80 of your local system, this can be done by simply going to [http://localhost/](http://localhost/)

The connection details for the docker environment is taken from the project .env file. Meaning whatever connections you set in your .env file will automatically be used in your docker container. By default to connect to the pgsql container you can access it at the following:

| key | Value |
|--|:--:|
| Host | localhost |
| Port | 5432 |
| Username | sail |
| Password | password |
| Database | laravel |
