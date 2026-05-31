# Quickstart: SurveyKita Local Development

## Prerequisites

- PHP 8.3 or newer
- Composer
- Bun
- Docker with Docker Compose

## Setup

```bash
composer install
bun install
docker compose up -d
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
bun run build
php artisan test
php artisan route:list
```

## Required Environment

`.env.example` must include:

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
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

## Local Database

`docker-compose.yml` must provide a MariaDB service with:

- database: `surveykita`
- username: `surveykita`
- password: `surveykita`
- host port: `3306`

## Demo Accounts

Seeders must document real demo credentials in README, including:

- Admin account
- At least one mahasiswa account with complete profile
- At least one mahasiswa account with incomplete profile

Google OAuth demo depends on valid Google credentials. Tests must use Socialite
fakes and must not require live Google requests.

## Manual Verification Flow

1. Start the app with `php artisan serve --host=127.0.0.1 --port=8000`.
2. Log in as admin.
3. Open admin dashboard.
4. Manage students, periods, forms, categories, and questions.
5. Open result dashboard and a result detail page.
6. Export PDF and Excel reports.
7. Log out.
8. Log in as a mahasiswa.
9. Complete profile if needed.
10. Open active evaluations.
11. Submit one active evaluation.
12. Confirm duplicate submission is blocked.
13. Open submission history.
14. Confirm route boundaries by trying cross-role pages.

## Agent Browser End-to-End Verification

Use `agent-browser` after migrations, seeders, build, and Pest tests pass. This
browser verification is required in addition to Pest tests.

Load the installed workflow before browser commands:

```bash
agent-browser skills get core
```

Run the app in one terminal:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Then use `agent-browser` to verify the seeded UI workflows:

```bash
agent-browser open http://127.0.0.1:8000/login
agent-browser snapshot -i
```

Required browser checks:

- Admin login, admin dashboard, and logout.
- Student, period, form, category, and question navigation and forms.
- Result dashboard, result detail page, charts, PDF export, and Excel export.
- Mahasiswa login, profile completion when needed, active form list, form detail,
  evaluation submission, success page, duplicate submission feedback, and
  submission history.
- Wrong-role access attempts show safe feedback.
- At least one empty result state renders without errors.

Capture snapshots or screenshots for the main dashboard, evaluation submission,
result charts, PDF export trigger, Excel export trigger, duplicate submission
feedback, and wrong-role feedback. Close task-owned browser sessions when done:

```bash
agent-browser close --all
pgrep -af "agent-browser|chrome|chromium" || true
```

## Required Test Command

```bash
php artisan test
```

The suite must include the required Pest feature and unit tests listed in
`plan.md` and `spec.md`.
