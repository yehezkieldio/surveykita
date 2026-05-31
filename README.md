# SurveyKita

## Requirements

- PHP 8.5
- Composer
- Bun
- Docker (for MariaDB)
- MariaDB compatible client (if not using Docker)

## Setup

```bash
git clone <repo-url> surveykita
cd surveykita
cp .env.example .env
composer install
bun install

docker compose up -d
php artisan key:generate
php artisan migrate:fresh --seed
bun run build
```

## Run

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Open:

```text
http://127.0.0.1:8000/login
```

## Environment values (important)

Edit `.env` for local setup:

```dotenv
APP_URL=http://localhost:8000
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surveykita
DB_USERNAME=surveykita
DB_PASSWORD=surveykita

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
```

## Helpful checks

```bash
php artisan route:list --except-vendor
php artisan test --compact
```
