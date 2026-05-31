# SurveyKita Implementation Report

This report is the running evidence log for the unattended `/goal` execution.
It records implementation decisions, issue progress, verification commands, and
remaining work. Keep this file current after each coherent slice.

## Current State

- Branch: `001-surveykita-evaluations`
- Remote: `https://github.com/yehezkieldio/surveykita.git`
- Active task range: GitHub Issues `#1` through `#41`
- Last updated: 2026-05-31 23:14 Asia/Makassar

## Decisions

- `maatwebsite/excel` stable `3.1.x` does not install on PHP 8.5 / Laravel 13.
  Composer reports Laravel 13 and PHP 8.5 compatibility only on the upstream
  `4.x-dev` branch, so the implementation uses `maatwebsite/excel:4.x-dev`.
  This preserves the required package while avoiding insecure or incompatible
  older spreadsheet dependencies.

## Issue Progress

| Issue | Task | Status | Commit | Verification |
| --- | --- | --- | --- | --- |
| `#1` | T001 `chore(project): align allowed dependencies` | Closed | `c8d92f3` | `composer validate`; `composer show --locked laravel/socialite`; `composer show --locked akaunting/laravel-apexcharts`; `composer show --locked barryvdh/laravel-dompdf`; `composer show --locked maatwebsite/excel`; `composer show --locked pestphp/pest`; `composer show --locked pestphp/pest-plugin-laravel`; banned dependency scan |
| `#2` | T002 `chore(project): register route files and middleware aliases` | Closed | `518ec7e` | `vendor/bin/pint --dirty --format agent`; `php artisan route:list --except-vendor` |
| `#3` | T003 `chore(dev): configure MariaDB local services` | Ready to commit | pending | `docker compose config`; `php artisan config:show database.default` |

## Verification Log

### 2026-05-31 23:00 Asia/Makassar

- Ran `composer require akaunting/laravel-apexcharts:^4.0 barryvdh/laravel-dompdf:^3.1 maatwebsite/excel:4.x-dev --with-all-dependencies --no-interaction`.
- Composer installed:
  - `akaunting/laravel-apexcharts` `4.0.0`
  - `barryvdh/laravel-dompdf` `v3.1.2`
  - `maatwebsite/excel` `4.x-dev 86cce13`
  - already-present `laravel/socialite`, `pestphp/pest`, and
    `pestphp/pest-plugin-laravel`
- Ran `composer validate`; it passed with a warning about the exact `4.x-dev`
  version constraint, which is intentional due to the current compatibility
  state.
- Ran individual `composer show --locked ...` checks for every T001 required
  Composer package.
- Ran a banned dependency scan against `composer.json`, `package.json`,
  `bun.lock`, `composer.lock`, and `.npmrc`. Matches were only incidental words
  such as Composer autoload `bootstrap.php` and `tslib` in the Bun lockfile, not
  banned project dependencies.
- Committed `c8d92f3` with Conventional Commit message
  `chore(project): align SurveyKita dependencies` and closed GitHub Issue `#1`
  as completed.

### 2026-05-31 23:08 Asia/Makassar

- Registered `routes/auth.php` through `bootstrap/app.php` using Laravel 13
  `withRouting(... then:)` routing customization.
- Registered middleware aliases `role` and `student.profile.complete` for the
  project middleware classes.
- Replaced the default welcome closure route with a root redirect named `home`.
- Created empty auth route groups without business logic so later auth tasks can
  attach controller routes without route-file drift.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `php artisan route:list --except-vendor`; passed and showed the root
  redirect route.
- Committed and pushed `518ec7e` with Conventional Commit message
  `chore(project): register SurveyKita route foundation` and closed GitHub
  Issue `#2` as completed.

### 2026-05-31 23:14 Asia/Makassar

- Added a root `docker-compose.yml` MariaDB 11.4 service named
  `surveykita-mariadb`, exposing host port `3306` and creating the
  `surveykita` database/user/password from the quickstart.
- Updated `.env.example` to use `APP_URL=http://localhost:8000`, MariaDB
  credentials `surveykita` / `surveykita`, and Google OAuth placeholder
  variables with callback `/auth/google/callback`.
- Changed Laravel's database default fallback from SQLite to MariaDB so fresh
  local configuration does not drift to the banned main development database.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `docker compose config`; passed and showed the MariaDB service, port,
  healthcheck, and named volume.
- Ran `php artisan config:show database.default`; passed and reported
  `mariadb`.

## Remaining Gates

- Continue T002 through T041 in dependency order.
- Keep this report updated with commits, issue closures, verification evidence,
  browser E2E results, and final completion decision.
