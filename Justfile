set dotenv-load

default:
    @just --list

install:
    composer install
    bun install

setup:
    @test -f .env || cp .env.example .env
    composer install
    php artisan key:generate --ansi
    just docker-up
    just db-wait
    php artisan migrate --seed --no-interaction
    bun install
    bun run build

dev:
    composer run dev

serve:
    php artisan serve

vite:
    bun run dev

build:
    bun run build

queue:
    php artisan queue:listen --tries=1 --timeout=0

logs:
    php artisan pail --timeout=0

test *args:
    php artisan test --compact {{args}}

test-filter filter:
    php artisan test --compact --filter="{{filter}}"

fmt:
    vendor/bin/pint --dirty --format agent

fmt-all:
    vendor/bin/pint --format agent

routes *args:
    php artisan route:list --except-vendor {{args}}

tinker:
    php artisan tinker

clear:
    php artisan optimize:clear

cache:
    php artisan optimize

migrate:
    php artisan migrate --no-interaction

migrate-fresh:
    php artisan migrate:fresh --no-interaction

seed:
    php artisan db:seed --no-interaction

db-refresh:
    php artisan migrate:fresh --seed --no-interaction

db-status:
    php artisan migrate:status

db-shell:
    docker compose exec mariadb mariadb -usurveykita -psurveykita surveykita

db-wait:
    @for attempt in $(seq 1 30); do \
        if docker compose exec mariadb healthcheck.sh --connect --innodb_initialized >/dev/null 2>&1; then \
            echo "MariaDB is ready"; \
            exit 0; \
        fi; \
        sleep 2; \
    done; \
    echo "MariaDB did not become ready in time" >&2; \
    exit 1

docker-up:
    docker compose up -d

docker-down:
    docker compose down

docker-restart:
    docker compose restart

docker-logs:
    docker compose logs -f mariadb

docker-ps:
    docker compose ps

docker-shell:
    docker compose exec mariadb bash

docker-reset:
    docker compose down --volumes --remove-orphans
    docker compose up -d
    just db-wait

reset-local:
    just docker-reset
    php artisan migrate:fresh --seed --no-interaction
    php artisan optimize:clear

doctor:
    php artisan about
    docker compose ps
    php artisan migrate:status
