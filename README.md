# Laravel Management System

A small sales and stock management app built with Laravel. Users sign in, browse products (with brand, category and stock per location) and record sales. The dashboard shows this month's revenue, cost and profit.

## Requirements

- PHP 8.4+ with Composer (Laravel 13)
- MySQL (or SQLite for a quick local try)
- Node.js for the front-end assets

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

`--seed` adds demo brands, categories, products and payment methods, plus a demo account: `demo@example.com` / `password`.
