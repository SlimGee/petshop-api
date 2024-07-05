## About

The petshop api

## Installation

To run this project simply clone this rep

```bash
git clone git@github.com:SlimGee/petshop-api.git
```

Install dependencies

```bash
cd petshop-api
```

```bash
composer install
```

```bash
yarn install
```

This project uses `spatie/laravel-pdf` to generate pdf files, which uses `puppeteer`. To be on the safe side you might have to install chromium on your machine. You can do that by running the following command
```bash
yarn puppeteer browsers install chrome
```

## Usage

Before you can use this project you need to create a `.env` file in the root directory of the project. You can copy the `.env.example` file and rename it to `.env`.
```bash
cp .env.example .env
```

Configure the database connection in the `.env` file

Migrate the database
```bash
php artisan migrate
```

Seed the database
```bash
php artisan db:seed
```

If you have Laravel Valet installed you can run the project by running the following command
```bash
valet open
```

Otherwise you use the built-in server
```bash
php artisan serve
```

## Documentation
Assuming you have valet installed, you can access the documentation by visiting [http://petshop-api.test/api/swagger](http://petshop-api.test/api/swagger)

Or you can visit the `/api/swagger` route on your local server

