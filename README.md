# Car Parking Project

Car Parking Project include Admin & Owner

## Usage

[Laravel 7](https://laravel.com/docs/7.x/releases)

[Laradock](https://laradock.io/)

[Laravel & Module](https://github.com/nWidart/laravel-modules)

## Installation

Clone Car Parking Project repository

```bash
```

Clone and update gitsubmodule

```bash
    git submodule init
    git submodule update --init --recursive
```
In Project folder

```bash
    cp .env.develop .env
```

Init & Run Laradock

- Clone Laradock into Project folder
```bash
    git clone git@github.com:laradock/laradock.git
```

- Config .env of Laradock
```bash
    cp laradock.env.example laradock/.env
    cd laravel
```

- Run docker
```bash
    docker-compose up -d nginx mysql workspace
```

- In /laradock folder install composer
```bash
    docker-compose exec workspace bash
    composer install
    npm install
    npm run dev
```

- Run migration
```bash
    docker-compose exec workspace php artisan migrate 
```

- See result
```open webrowser localhost:90
```

- Run Redoc
```bash 
    cd/redoc
    npx http-server -c -1 -o -p 3006 .  
```

- Setup server to upload large file
```bash 
    In laradock/nginx/nginx.conf: set client_max_body_size = 200M
    In laradock/php-fpm/laravel.ini: set upload_max_filesize = 200M and post_max_size = 200M
    In laradock/php-fpm/php7.3.ini: set post_max_size = 200M and post_max_size = 200M
    Stop server
    Run: docker-compose build --no-cache php-fpm
         docker-compose build --no-cache nginx
    Restart server
```

