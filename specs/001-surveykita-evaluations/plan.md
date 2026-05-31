# Implementation Plan: SurveyKita Academic Evaluation System

**Branch**: `001-surveykita-evaluations` | **Date**: 2026-05-31 | **Spec**: [spec.md](./spec.md)

**Input**: Feature specification from `/specs/001-surveykita-evaluations/spec.md`

**Note**: This plan covers the complete SurveyKita application. Every required
module is included in the implementation scope.

## Summary

SurveyKita is a complete Laravel 13 Blade/Tailwind information system for
Universitas Mulia student satisfaction evaluations toward academic services.
Admin users manage mahasiswa data, evaluation periods, forms, categories,
questions, results, charts, and exports. Mahasiswa users authenticate through
password or restricted student Google OAuth, complete their student profile, and
submit one Likert response per active evaluation form during an active inclusive
period date range.

The implementation uses simple Laravel conventions: Eloquent models, migrations,
factories, seeders, Form Requests, grouped controllers, role/profile middleware,
an `EvaluationResultService`, Excel export classes, Blade PDF templates, reusable
Blade components, and Pest feature/unit tests.

## Technical Context

**Language/Version**: PHP 8.3+ with Laravel 13. Current local app reports PHP
8.5 and Laravel 13.12.

**Primary Dependencies**: Laravel Blade, Tailwind CSS, Vite, Laravel Socialite,
akaunting/laravel-apexcharts, barryvdh/laravel-dompdf, Maatwebsite Excel,
Pest, pest-plugin-laravel.

**Storage**: MariaDB through Docker Compose for local development.

**Testing**: Pest feature and unit tests through `php artisan test`, followed by
`agent-browser` end-to-end browser verification against the seeded local app.

**Execution Mode**: Unattended autonomous long-horizon implementation. The
agent may use non-interactive commands, install approved dependencies, reset the
local database, run seeders, start and stop local services, execute tests, use
`agent-browser`, fix failures, and continue until verification gates pass.

**Target Platform**: Local web application served by Laravel for university
project demonstration and grading.

**Project Type**: Laravel Blade web application.

**Performance Goals**: Paginated admin tables; dashboard/report queries use
indexes, aggregate queries, and eager loading; result pages avoid known N+1
paths; response submission is wrapped in one transaction.

**Constraints**: Must use custom Laravel session auth, role middleware,
student-profile completion middleware, Blade/Tailwind UI, Bun, Vite, MariaDB,
Docker Compose, Socialite Google OAuth, ApexCharts, PDF export, Excel export,
and Pest. Must not use Laravel Breeze, Jetstream, Laravel UI, Bootstrap, React,
Vue, Inertia, Livewire, Filament, Nova, Backpack, SQLite as main local DB, npm,
yarn, pnpm, or admin panel generators.

**Scale/Scope**: Complete SurveyKita application covering authentication,
student-only Google OAuth, admin CRUD, evaluation submission, Likert
calculation, dashboards, charts, PDF export, Excel export, seed data, tests,
local MariaDB setup, README instructions, and unattended browser verification.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- Whole-app delivery: PASS. Plan maps every required route to a controller,
  response/view, role boundary, and test expectation.
- Stack compliance: PASS. Plan uses Laravel 13, Blade, Tailwind, Bun, Vite,
  MariaDB, Pest, Socialite, akaunting/laravel-apexcharts, DomPDF, and
  Maatwebsite Excel. Banned starter kits, admin panels, frontend frameworks,
  Bootstrap, SQLite main DB, npm/yarn/pnpm, and Livewire are excluded.
- Auth and authorization: PASS. Plan includes manual login/logout controllers,
  session regeneration/invalidation, Form Requests, role middleware, profile
  middleware, and safe redirects.
- Google OAuth: PASS. Plan restricts OAuth to lowercase
  `@students.universitasmulia.ac.id`, creates/links only mahasiswa users, never
  creates admins, and blocks incomplete profiles from submission.
- Domain logic: PASS. Plan centralizes all result math in
  `EvaluationResultService` and keeps business logic out of controllers/views.
- Database integrity: PASS. Plan includes foreign keys, unique constraints,
  nullable unique NIM, score checks where MariaDB supports them, and dashboard
  indexes.
- Testing: PASS. Plan includes Pest coverage for auth, roles, Google OAuth,
  profile completion, CRUD, submissions, calculations, protected exports, seed
  data, and route/UI wiring, followed by `agent-browser` browser verification
  of seeded end-to-end admin and mahasiswa workflows.
- No placeholders: PASS. Plan requires all visible actions and pages to be wired
  and treats fake UI/dead routes/empty tests as defects.
- Reproducibility: PASS. Plan includes Docker Compose MariaDB, `.env.example`,
  migrations, seeders, Bun build, test commands, route listing, and demo
  accounts.

**Post-design re-check**: PASS. Generated `research.md`, `data-model.md`,
`quickstart.md`, and `contracts/` preserve every constitution gate.

## Project Structure

### Documentation (this feature)

```text
specs/001-surveykita-evaluations/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
│   ├── route-contract.md
│   ├── ui-contract.md
│   └── report-contract.md
└── tasks.md
```

### Source Code (repository root)

```text
app/
├── Exports/
│   ├── EvaluationReportExport.php
│   └── Sheets/
│       ├── SummarySheet.php
│       ├── CategoryRecapSheet.php
│       ├── QuestionRecapSheet.php
│       ├── LikertDistributionSheet.php
│       ├── SuggestionsSheet.php
│       └── RawResponsesSheet.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── EvaluationFormController.php
│   │   │   ├── EvaluationPeriodController.php
│   │   │   ├── QuestionCategoryController.php
│   │   │   ├── QuestionController.php
│   │   │   ├── ReportExportController.php
│   │   │   ├── ResultController.php
│   │   │   └── StudentController.php
│   │   ├── Auth/
│   │   │   ├── GoogleAuthController.php
│   │   │   ├── LoginController.php
│   │   │   └── LogoutController.php
│   │   └── Student/
│   │       ├── DashboardController.php
│   │       ├── EvaluationController.php
│   │       ├── ProfileController.php
│   │       └── SubmissionController.php
│   ├── Middleware/
│   │   ├── EnsureStudentProfileIsComplete.php
│   │   └── EnsureUserHasRole.php
│   └── Requests/
│       ├── Admin/
│       ├── Auth/
│       └── Student/
├── Models/
│   ├── EvaluationForm.php
│   ├── EvaluationPeriod.php
│   ├── Question.php
│   ├── QuestionCategory.php
│   ├── Response.php
│   ├── ResponseAnswer.php
│   ├── Student.php
│   └── User.php
└── Services/
    ├── EvaluationResultService.php
    └── NimParser.php

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/app.css
├── js/app.js
└── views/
    ├── admin/
    ├── auth/
    ├── components/
    ├── layouts/
    ├── pdf/
    └── student/

routes/
├── auth.php
└── web.php

tests/
├── Feature/
│   ├── Admin/
│   ├── Auth/
│   ├── Exports/
│   └── Student/
└── Unit/
    └── Services/

docker-compose.yml
README.md
```

**Structure Decision**: Use one conventional Laravel app. Controllers are grouped
by `Admin`, `Student`, and `Auth` to match role boundaries without introducing
extra architecture. Result math lives in one service. Export formatting lives in
export/sheet classes and PDF Blade templates. Views remain custom Blade with
Tailwind components.

## Architecture Plan

### Authentication And Roles

- `Auth\LoginController`: `create()` renders `auth.login`; `store()` validates
  email/password through `LoginRequest`, uses `Auth::attempt`, regenerates the
  session, and redirects by role.
- `Auth\LogoutController`: destroys the authenticated session via `Auth::logout`,
  session invalidation, and CSRF token regeneration.
- `Auth\GoogleAuthController`: `redirect()` starts Google OAuth; `callback()`
  fetches provider user, lowercases email, enforces
  `@students.universitasmulia.ac.id`, creates/links only mahasiswa users,
  authenticates them, and redirects to profile completion when needed.
- `EnsureUserHasRole`: accepts `admin` or `mahasiswa` and rejects cross-role
  access with safe Indonesian feedback.
- `EnsureStudentProfileIsComplete`: only for mahasiswa evaluation submission
  routes; redirects incomplete profiles to `/student/profile/complete`.
- Public registration routes are not created.

### Admin Modules

- `Admin\DashboardController`: summary of active periods/forms/respondents and
  links into management/result pages.
- `Admin\StudentController`: manual mahasiswa user/profile CRUD with safe delete
  blocking when responses exist.
- `Admin\EvaluationPeriodController`: CRUD plus `is_active` toggling.
- `Admin\EvaluationFormController`: CRUD plus `is_active` toggling and period
  ownership.
- `Admin\QuestionCategoryController`: CRUD for evaluation areas.
- `Admin\QuestionController`: CRUD scoped to forms/categories with sort order.
- `Admin\ResultController`: index and form detail views powered only by
  `EvaluationResultService`.
- `Admin\ReportExportController`: PDF and Excel exports, admin-only.

### Mahasiswa Modules

- `Student\DashboardController`: active/open form summary and submitted status.
- `Student\ProfileController`: create/update required profile fields.
- `Student\EvaluationController`: active form list, form detail, fill view, and
  transactional submit.
- `Student\SubmissionController`: submission success page and status/history.

### Student NIM Parsing

- `NimParser` parses seven-digit Universitas Mulia NIM values in `TTAABBB`
  format.
- `TT` becomes full enrollment year `20TT`.
- `AA` maps to the known program-study code table from the specification.
- `BBB` remains a three-digit sequence number with leading zeroes preserved.
- Admin student requests, student profile completion requests, Google-created
  NIM defaults, factories, seeders, and tests must use the same parser.
- Unknown program codes or malformed NIM values fail validation with Indonesian
  feedback.

### Domain Service

`EvaluationResultService` accepts filter context (`period_id`, `form_id`,
`category_id`) and returns an immutable array or DTO-like value with:

- total respondents
- total answers
- average score
- satisfaction percentage
- satisfaction category
- average score per category
- average score per question
- Likert score distribution for 1-5
- suggestion/comment list
- zero-safe empty state

Controllers and Blade views must not repeat calculation logic.

### Routes

- Public/auth routes live in `routes/auth.php` and are loaded from `routes/web.php`.
- Admin routes use `auth` and `role:admin`, names prefixed with `admin.`.
- Student routes use `auth` and `role:mahasiswa`, names prefixed with `student.`.
- Submission routes add `student.profile.complete`.
- Route model binding is used for forms and admin resources; authorization
  checks still enforce role boundaries.

### UI Plan

- Layouts: `layouts.guest`, `layouts.admin`, `layouts.student`.
- Components: cards, tables, badges, buttons, alerts, empty states, form errors,
  pagination, chart panels, and confirmation dialogs.
- Labels and validation feedback use Indonesian wording.
- Charts use real service output and never placeholder arrays.
- Every navigation item points to an implemented named route.

### Reporting Plan

- PDF: `resources/views/pdf/evaluation-report.blade.php` rendered through
  DomPDF from `ReportExportController@pdf`.
- Excel: `EvaluationReportExport` with sheets for summary, category recap,
  question recap, Likert distribution, suggestions, and raw responses.
- Both exports use the same `EvaluationResultService` output as dashboards.
- Empty result exports still include headers, filters, and zero-safe summary.

## Complexity Tracking

No constitution violations. Additional packages are required by the constitution
and user plan request.

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| None | N/A | N/A |

## Verification Gates

Before implementation is considered complete:

1. `composer install`
2. `bun install`
3. `docker compose up -d`
4. `cp .env.example .env`
5. `php artisan key:generate`
6. `php artisan migrate:fresh --seed`
7. `bun run build`
8. `php artisan test`
9. `php artisan route:list`
10. `agent-browser skills get core`
11. Start the local server and use `agent-browser` to complete seeded admin and
    mahasiswa workflows, capture snapshots or screenshots for the dashboard,
    evaluation submission, charts, PDF export, Excel export, role boundaries,
    and empty states, then close task-owned browser sessions.
12. If a gate fails, apply a targeted fix and rerun the smallest failing gate
    before returning to the full verification sequence. Do not wait for human
    preference decisions during unattended execution; use the specification,
    plan, tasks, and README defaults.
