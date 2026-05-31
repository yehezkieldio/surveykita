# SurveyKita Implementation Report

This report is the running evidence log for the unattended `/goal` execution.
It records implementation decisions, issue progress, verification commands, and
remaining work. Keep this file current after each coherent slice.

## Current State

- Branch: `001-surveykita-evaluations`
- Remote: `https://github.com/yehezkieldio/surveykita.git`
- Active task range: GitHub Issues `#1` through `#41`
- Last updated: 2026-06-01 00:27 Asia/Makassar

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
| `#3` | T003 `chore(dev): configure MariaDB local services` | Closed | `2335819` | `docker compose config`; `php artisan config:show database.default` |
| `#4` | T004 `chore(frontend): configure Bun, Vite, Tailwind, and assets` | Closed | `1c8f62c` | `bun install --frozen-lockfile`; `bun run build` |
| `#5` | T005 `style(ui): create shared Blade layouts and components` | Closed | `1c8f62c` | `bun run build` |
| `#6` | T006 `test(auth): cover custom login and logout behavior` | Closed | `520d9bf` | Red: `php artisan test --compact --filter=SessionAuthTest`; Green: `php artisan test --compact --filter=SessionAuthTest` |
| `#7` | T007 `feat(auth): implement custom session login and logout` | Closed | `520d9bf` | `vendor/bin/pint --dirty --format agent`; `php artisan route:list --except-vendor`; `php artisan test --compact --filter=SessionAuthTest` |
| `#8` | T008 `test(auth): cover admin and mahasiswa route boundaries` | Closed | `204052a` | Red: `php artisan test --compact --filter=RoleAccessTest`; Green: `php artisan test --compact --filter=RoleAccessTest` |
| `#9` | T009 `feat(auth): implement role middleware and protected route groups` | Closed | `204052a` | `vendor/bin/pint --dirty --format agent`; `php artisan route:list --except-vendor`; `php artisan test --compact --filter=RoleAccessTest`; `bun run build` |
| `#10` | T010 `test(auth): cover Google OAuth student-domain behavior` | Closed | `5544cfb` | Red: `php artisan test --compact --filter=GoogleOAuthTest`; Green: `php artisan test --compact --filter=GoogleOAuthTest` |
| `#11` | T011 `feat(auth): implement student-only Google OAuth` | Closed | `5544cfb` | `vendor/bin/pint --dirty --format agent`; `php artisan route:list --except-vendor --path=auth/google`; `php artisan test --compact --filter=GoogleOAuthTest`; `php artisan test --compact --filter=SessionAuthTest`; `bun run build` |
| `#12` | T012 `chore(db): create SurveyKita migrations with constraints and indexes` | Closed | `6dc1462` | `vendor/bin/pint --dirty --format agent`; `php artisan migrate:fresh --no-interaction`; `php artisan schema:dump --prune --database=mariadb --no-interaction` with migration backup/restore; auth regression tests; Laravel Boost schema inspection |

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
- Committed and pushed `2335819` with Conventional Commit message
  `chore(dev): configure MariaDB local development` and closed GitHub Issue
  `#3` as completed.

### 2026-05-31 23:23 Asia/Makassar

- Added Tailwind `@source '../views/**/*.blade.php'` so app Blade files are
  included in Tailwind CSS generation.
- Added a minimal JavaScript bootstrap entry and kept the Vite input on
  `resources/css/app.css` plus `resources/js/app.js`.
- Created guest, admin, and mahasiswa layouts with Indonesian labels, guarded
  route-name usage, Vite assets, CSRF metadata, flash alerts, and real logout
  forms once the route exists.
- Added reusable Blade components for alerts, badges, buttons, cards, empty
  states, form errors, pagination, and tables.
- Removed the default Laravel welcome view so the UI foundation no longer
  carries starter-kit placeholder content.
- Ran `bun install --frozen-lockfile`; passed with no lockfile changes.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `bun run build`; passed and produced `public/build/manifest.json`.
- Committed and pushed `1c8f62c` with Conventional Commit message
  `style(ui): establish SurveyKita Blade foundation` and closed GitHub Issues
  `#4` and `#5` as completed.

### 2026-05-31 23:39 Asia/Makassar

- Wrote `tests/Feature/Auth/SessionAuthTest.php` covering login page rendering,
  admin login redirect, mahasiswa login redirect, invalid credential feedback,
  and logout session invalidation.
- Ran `php artisan test --compact --filter=SessionAuthTest` before
  implementation; it failed with five 404 failures because `/login` and
  `/logout` were not wired yet.
- Added the minimal user auth fields required by the auth track:
  `role`, nullable `google_id`, nullable `password`, model role helpers, and
  factory role states. The full domain schema remains scheduled for T012.
- Implemented `LoginController`, `LogoutController`, `LoginRequest`, auth
  routes, login view, and unauthorized feedback view using Laravel session auth
  primitives.
- Added layout component wrappers under `resources/views/components/layouts`
  so `<x-layouts.*>` resolves while the canonical layout files remain under
  `resources/views/layouts`.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `php artisan route:list --except-vendor`; passed and showed login and
  logout routes.
- Ran `php artisan test --compact --filter=SessionAuthTest`; passed with 5
  tests and 21 assertions.
- Committed and pushed `520d9bf` with Conventional Commit message
  `feat(auth): implement custom session authentication` and closed GitHub
  Issues `#6` and `#7` as completed.

### 2026-05-31 23:55 Asia/Makassar

- Wrote `tests/Feature/Auth/RoleAccessTest.php` for unauthenticated redirects,
  admin dashboard access, mahasiswa dashboard access, cross-role dashboard
  blocking, admin evaluation-submission blocking, and mahasiswa result/export
  route blocking.
- Ran `php artisan test --compact --filter=RoleAccessTest` before
  implementation; it failed on missing protected routes.
- Implemented `EnsureUserHasRole` with variadic role checks and 403 feedback.
- Added controller-backed admin route boundaries for dashboard, students,
  periods, forms, categories, questions, results, PDF export, and Excel export.
- Added controller-backed mahasiswa route boundaries for dashboard, profile
  completion, active evaluations, evaluation submission, and submission history.
- Added minimal real Blade views for the protected dashboard/module boundaries;
  CRUD, calculation, chart, and export behavior remains tracked by later
  dedicated issues.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `php artisan route:list --except-vendor`; passed and showed 19
  controller-backed routes.
- Ran `php artisan test --compact --filter=RoleAccessTest`; passed with 9
  tests and 14 assertions.
- Ran `bun run build`; passed.
- Committed and pushed `204052a` with Conventional Commit message
  `feat(auth): enforce role route boundaries` and closed GitHub Issues `#8`
  and `#9` as completed.

### 2026-06-01 00:08 Asia/Makassar

- Wrote `tests/Feature/Auth/GoogleOAuthTest.php` using `Socialite::fake` for
  provider redirect, allowed student email creation, lowercase normalization,
  non-student rejection, existing mahasiswa linking, existing admin rejection,
  and incomplete-profile redirect.
- Ran `php artisan test --compact --filter=GoogleOAuthTest` before
  implementation; it failed with six 404 failures because Google OAuth routes
  were absent.
- Implemented `GoogleAuthController` with Google redirect, callback, strict
  lowercase `@students.universitasmulia.ac.id` filtering, mahasiswa-only
  create/link behavior, admin rejection, session login, and profile-completion
  redirect.
- Added Google service configuration from `GOOGLE_CLIENT_ID`,
  `GOOGLE_CLIENT_SECRET`, and `GOOGLE_REDIRECT_URI`.
- Added Google OAuth routes and rejection feedback page; the login page now
  shows a real Google login action because the route exists.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `php artisan route:list --except-vendor --path=auth/google`; passed and
  showed redirect, callback, and rejection routes.
- Ran `php artisan test --compact --filter=GoogleOAuthTest`; passed with 6
  tests and 28 assertions.
- Ran `php artisan test --compact --filter=SessionAuthTest`; passed with 5
  tests and 21 assertions.
- Ran `bun run build`; passed.
- Committed and pushed `5544cfb` with Conventional Commit message
  `feat(auth): add student-only Google OAuth` and closed GitHub Issues `#10`
  and `#11` as completed.

### 2026-06-01 00:24 Asia/Makassar

- Completed SurveyKita database migrations for `students`,
  `evaluation_periods`, `evaluation_forms`, `question_categories`,
  `questions`, `responses`, and `response_answers`.
- Extended the base `users` migration with `role`, `google_id`, nullable
  `password`, `users.email` uniqueness, `users.google_id` index, and a
  MariaDB role check constraint.
- Added required student profile columns and indexes:
  nullable unique `nim`, unique `user_id`, `program_code`, `study_program`,
  `enrollment_year`, `sequence_number`, and `class_name`.
- Added foreign keys, unique constraints, and reporting indexes for forms,
  questions, responses, and response answers.
- Added MariaDB check constraints for evaluation period date ordering and
  response answer scores between 1 and 5.
- Initial `php artisan migrate:fresh --no-interaction` failed because local
  `.env` still used `root` without a password while the compose service uses
  the `surveykita` user. Corrected only local non-secret DB credentials in
  `.env`, then cleared config.
- Ran `vendor/bin/pint --dirty --format agent`; passed.
- Ran `php artisan migrate:fresh --no-interaction`; passed all migrations.
- Ran `php artisan schema:dump --prune --database=mariadb --no-interaction`
  with a temporary migration backup and immediate restore, because `--prune`
  deletes migration source files by design; command passed.
- Removed the generated schema dump file after verification so migrations
  remain the source of truth during this active implementation.
- Ran auth regression tests:
  `SessionAuthTest`, `GoogleOAuthTest`, and `RoleAccessTest`; all passed.
- Inspected the live MariaDB schema with Laravel Boost. Confirmed SurveyKita
  tables exist and `response_answers_score_check`,
  `responses_evaluation_form_id_student_id_unique`,
  `response_answers_response_id_question_id_unique`, student unique indexes,
  and foreign keys are present.
- Committed and pushed `6dc1462` with Conventional Commit message
  `chore(db): add SurveyKita domain schema` and closed GitHub Issue `#12` as
  completed.

## Remaining Gates

- Continue T002 through T041 in dependency order.
- Keep this report updated with commits, issue closures, verification evidence,
  browser E2E results, and final completion decision.
