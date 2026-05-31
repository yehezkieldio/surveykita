# Tasks: SurveyKita Academic Evaluation System

**Input**: Design documents from `/specs/001-surveykita-evaluations/`

**Prerequisites**: `plan.md`, `spec.md`, `research.md`, `data-model.md`, `quickstart.md`, and `contracts/`

**Tests**: Pest tests are required for real behavior. Tests must cover happy paths, role boundaries, validation failures, calculation correctness, exports, and seeded demonstration data.
`agent-browser` is also required for browser-level end-to-end verification after
the app is running locally; it does not replace Pest coverage.
Implementation is expected to run unattended for a long-horizon autonomous
session. Tasks must be written and executed with documented defaults,
non-interactive commands, local cleanup, and targeted retry loops rather than
waiting for human choices.

**Organization**: Tasks are grouped in the dependency order required for whole-app delivery. User-story labels map to the specification:

- **US1**: Admin manages evaluation program
- **US2**: Mahasiswa completes and submits evaluation
- **US3**: Admin reviews results, charts, and reports
- **US4**: Seeded local demonstration

Every task includes exact files likely to change, expected behavior, acceptance criteria, and a verification command or Pest test. No task is a placeholder for later work.

## Phase 1: Project Foundation

- [X] T001 chore(project): align allowed dependencies in `composer.json`, `composer.lock`, `package.json`, and `bun.lock`
  - Phase: Project foundation
  - Dependencies: None
  - Files: `composer.json`, `composer.lock`, `package.json`, `bun.lock`
  - Expected behavior: Required packages are present for Socialite, ApexCharts, DomPDF, Maatwebsite Excel, Pest, Vite, Tailwind, and Bun workflow; banned starter kits, admin panels, Bootstrap, React, Vue, Inertia, Livewire, npm, yarn, and pnpm are absent.
  - Acceptance criteria: `laravel/socialite`, `akaunting/laravel-apexcharts`, `barryvdh/laravel-dompdf`, `maatwebsite/excel`, `pestphp/pest`, and `pestphp/pest-plugin-laravel` are installed or explicitly retained; package scripts use Bun.
  - Verification: `composer validate && composer show laravel/socialite akaunting/laravel-apexcharts barryvdh/laravel-dompdf maatwebsite/excel pestphp/pest pestphp/pest-plugin-laravel`

- [X] T002 chore(project): register route files, middleware aliases, and app providers in `bootstrap/app.php`, `routes/web.php`, and `routes/auth.php`
  - Phase: Project foundation
  - Dependencies: T001
  - Files: `bootstrap/app.php`, `routes/web.php`, `routes/auth.php`, `app/Providers/AppServiceProvider.php`
  - Expected behavior: Web routes include auth routes; role and profile middleware aliases are available; route definitions stay controller-based.
  - Acceptance criteria: `routes/auth.php` is loaded from the web middleware group; middleware aliases `role` and `student.profile.complete` resolve; no closure route contains business logic.
  - Verification: `php artisan route:list --except-vendor`

## Phase 2: Environment and Docker Compose

- [X] T003 chore(dev): configure MariaDB local services in `docker-compose.yml` and `.env.example`
  - Phase: Environment and Docker Compose
  - Dependencies: T001
  - Files: `docker-compose.yml`, `.env.example`
  - Expected behavior: A fresh clone can start MariaDB locally with Docker Compose and Laravel reads MariaDB defaults from `.env.example`.
  - Acceptance criteria: Compose exposes MariaDB on a documented local port; `.env.example` contains `DB_CONNECTION=mariadb`, host, port, database, username, password, and Google OAuth placeholders.
  - Verification: `docker compose config && php artisan config:show database.default`

## Phase 3: Tailwind and Bun Frontend Setup

- [X] T004 chore(frontend): configure Bun, Vite, Tailwind, and Laravel asset entrypoints in `package.json`, `vite.config.js`, `resources/css/app.css`, and `resources/js/app.js`
  - Phase: Tailwind and Bun frontend setup
  - Dependencies: T001
  - Files: `package.json`, `bun.lock`, `vite.config.js`, `resources/css/app.css`, `resources/js/app.js`
  - Expected behavior: Frontend assets build through Bun and Vite with Tailwind CSS only.
  - Acceptance criteria: `bun run build` produces a Vite manifest; Tailwind scans Blade views; no Bootstrap, React, Vue, Inertia, or Livewire frontend dependency is added.
  - Verification: `bun install --frozen-lockfile && bun run build`

- [X] T005 style(ui): create shared Blade layouts and components in `resources/views/layouts/` and `resources/views/components/`
  - Phase: Tailwind and Bun frontend setup
  - Dependencies: T004
  - Files: `resources/views/layouts/guest.blade.php`, `resources/views/layouts/admin.blade.php`, `resources/views/layouts/student.blade.php`, `resources/views/components/alert.blade.php`, `resources/views/components/badge.blade.php`, `resources/views/components/button.blade.php`, `resources/views/components/card.blade.php`, `resources/views/components/empty-state.blade.php`, `resources/views/components/form-error.blade.php`, `resources/views/components/pagination.blade.php`, `resources/views/components/table.blade.php`
  - Expected behavior: Auth, admin, and mahasiswa pages share Indonesian Blade/Tailwind layouts and reusable UI primitives.
  - Acceptance criteria: Components support validation errors, flash messages, pagination, empty states, badges, and action buttons without fake links.
  - Verification: `bun run build`

## Phase 4: Custom Authentication

- [X] T006 test(auth): cover custom login and logout behavior in `tests/Feature/Auth/SessionAuthTest.php`
  - Phase: Custom authentication
  - Dependencies: T002, T005
  - Files: `tests/Feature/Auth/SessionAuthTest.php`
  - Expected behavior: Guest login page renders; valid admin and mahasiswa credentials authenticate; invalid credentials fail with errors; logout invalidates the session.
  - Acceptance criteria: Tests assert role-based post-login redirects, session authentication state, validation feedback, and logout state.
  - Verification: `php artisan test --compact --filter=SessionAuthTest`

- [X] T007 feat(auth): implement custom session login and logout in `app/Http/Controllers/Auth/`, `app/Http/Requests/Auth/`, `routes/auth.php`, and `resources/views/auth/`
  - Phase: Custom authentication
  - Dependencies: T006
  - Files: `app/Http/Controllers/Auth/LoginController.php`, `app/Http/Controllers/Auth/LogoutController.php`, `app/Http/Requests/Auth/LoginRequest.php`, `routes/auth.php`, `resources/views/auth/login.blade.php`, `resources/views/auth/unauthorized.blade.php`
  - Expected behavior: Login uses Laravel session authentication primitives, password hashing, session regeneration on login, session invalidation on logout, clear Indonesian errors, and safe redirects by role.
  - Acceptance criteria: Public registration routes are absent; visible login and logout actions are wired; admin redirects to `admin.dashboard`; mahasiswa redirects to `student.dashboard` or profile completion when needed.
  - Verification: `php artisan test --compact --filter=SessionAuthTest`

## Phase 5: Role and Authorization System

- [X] T008 test(auth): cover admin and mahasiswa route boundaries in `tests/Feature/Auth/RoleAccessTest.php`
  - Phase: Role and authorization system
  - Dependencies: T007
  - Files: `tests/Feature/Auth/RoleAccessTest.php`
  - Expected behavior: Admin can access admin routes, mahasiswa can access student routes, and cross-role access fails safely.
  - Acceptance criteria: Tests cover unauthenticated redirects, mahasiswa blocked from admin dashboard, admin blocked from evaluation submission, and export/result routes blocked for mahasiswa.
  - Verification: `php artisan test --compact --filter=RoleAccessTest`

- [X] T009 feat(auth): implement role middleware and protected route groups in `app/Http/Middleware/EnsureUserHasRole.php`, `bootstrap/app.php`, `routes/web.php`, and `routes/auth.php`
  - Phase: Role and authorization system
  - Dependencies: T008
  - Files: `app/Http/Middleware/EnsureUserHasRole.php`, `bootstrap/app.php`, `routes/web.php`, `routes/auth.php`, `resources/views/auth/unauthorized.blade.php`
  - Expected behavior: Route groups enforce `admin` and `mahasiswa` boundaries with safe redirects or 403 feedback.
  - Acceptance criteria: Admin-only routes include dashboard, students, periods, forms, categories, questions, results, PDF export, and Excel export; mahasiswa-only routes include dashboard, profile completion, evaluations, submission, and history.
  - Verification: `php artisan route:list --except-vendor && php artisan test --compact --filter=RoleAccessTest`

## Phase 6: Google OAuth Login

- [X] T010 test(auth): cover Google OAuth student-domain behavior in `tests/Feature/Auth/GoogleOAuthTest.php`
  - Phase: Google OAuth login
  - Dependencies: T007, T009
  - Files: `tests/Feature/Auth/GoogleOAuthTest.php`
  - Expected behavior: Allowed Universitas Mulia student email creates or links a mahasiswa account; non-student email is rejected; Google never creates admin users.
  - Acceptance criteria: Tests fake Socialite callbacks for allowed email, disallowed email, existing mahasiswa email, existing admin email, and incomplete profile redirect.
  - Verification: `php artisan test --compact --filter=GoogleOAuthTest`

- [X] T011 feat(auth): implement student-only Google OAuth in `app/Http/Controllers/Auth/GoogleAuthController.php`, `config/services.php`, `routes/auth.php`, and `resources/views/auth/login.blade.php`
  - Phase: Google OAuth login
  - Dependencies: T010
  - Files: `app/Http/Controllers/Auth/GoogleAuthController.php`, `config/services.php`, `routes/auth.php`, `resources/views/auth/login.blade.php`, `resources/views/auth/google-rejected.blade.php`
  - Expected behavior: Google redirect and callback use Laravel Socialite, lowercase email normalization, strict `@students.universitasmulia.ac.id` filtering, mahasiswa-only creation/linking, and rejection feedback.
  - Acceptance criteria: Google-created users have role `mahasiswa`, nullable password, linked `google_id`, optional incomplete student profile, and are redirected to completion before submissions.
  - Verification: `php artisan test --compact --filter=GoogleOAuthTest`

## Phase 7: Database Schema

- [X] T012 chore(db): create SurveyKita migrations with constraints and indexes in `database/migrations/`
  - Phase: Database schema
  - Dependencies: T003
  - Files: `database/migrations/0001_01_01_000000_create_users_table.php`, `database/migrations/*_create_students_table.php`, `database/migrations/*_create_evaluation_periods_table.php`, `database/migrations/*_create_evaluation_forms_table.php`, `database/migrations/*_create_question_categories_table.php`, `database/migrations/*_create_questions_table.php`, `database/migrations/*_create_responses_table.php`, `database/migrations/*_create_response_answers_table.php`
  - Expected behavior: Schema enforces core invariants with foreign keys, unique constraints, indexes, and score constraints where MariaDB supports them.
  - Acceptance criteria: `users.email` unique; `users.google_id` indexed; `students.user_id` unique; `students.nim` unique nullable; students include derived `program_code`, `study_program`, `enrollment_year`, and `sequence_number` columns with useful indexes for reporting; `responses` unique on form and student; `response_answers` unique on response and question; response score validates 1-5 at DB level where supported.
  - Verification: `php artisan migrate:fresh && php artisan schema:dump --prune --database=mariadb`

## Phase 8: Models and Relationships

- [X] T013 feat(model): implement Eloquent relationships, casts, helpers, and scopes in `app/Models/`
  - Phase: Models and relationships
  - Dependencies: T012
  - Files: `app/Models/User.php`, `app/Models/Student.php`, `app/Models/EvaluationPeriod.php`, `app/Models/EvaluationForm.php`, `app/Models/QuestionCategory.php`, `app/Models/Question.php`, `app/Models/Response.php`, `app/Models/ResponseAnswer.php`, `app/Services/NimParser.php`
  - Expected behavior: Models expose required relationships and helpers for role checks, profile completion, active periods, currently open periods, fillable forms, and parsed student NIM details.
  - Acceptance criteria: `User::student`, `Student::responses`, `EvaluationPeriod::evaluationForms`, `EvaluationForm::questions/responses`, `Question::evaluationForm/category`, `Response::answers/student/evaluationForm`, and `ResponseAnswer::response/question` are implemented; helpers `isAdmin`, `isMahasiswa`, `hasCompleteStudentProfile`, `scopeActive`, `isCurrentlyOpen`, and `isFillable` exist; `NimParser` parses `TTAABBB`, maps known Universitas Mulia program codes, preserves sequence leading zeroes, and rejects malformed or unknown-code NIM values.
  - Verification: `php artisan test --compact --filter=ModelAndRelationshipTest`

- [X] T014 test(student): cover NIM parsing and program-code mapping in `tests/Unit/Services/NimParserTest.php`
  - Phase: Models and relationships
  - Dependencies: T013
  - Files: `tests/Unit/Services/NimParserTest.php`
  - Expected behavior: NIM parsing is centralized, deterministic, and independent of controllers or Blade views.
  - Acceptance criteria: Tests cover valid NIM `2311032`, full enrollment year `2023`, program code `11`, study program `S1 Informatika`, sequence `032`, all configured program codes, malformed NIM values, and unknown program codes.
  - Verification: `php artisan test --compact --filter=NimParserTest`

## Phase 9: Factories and Seeders

- [X] T015 test(seed): cover seeded demonstration completeness in `tests/Feature/SeedDataTest.php`
  - Phase: Factories and seeders
  - Dependencies: T012, T013, T014
  - Files: `tests/Feature/SeedDataTest.php`
  - Expected behavior: Seeded data includes usable admin and mahasiswa accounts, active forms, realistic questions, and completed responses for dashboards.
  - Acceptance criteria: Tests assert at least one admin, several mahasiswa profiles with valid parsed NIM details, two periods, multiple forms, categories, 15-25 questions, and meaningful responses after `DatabaseSeeder`.
  - Verification: `php artisan test --compact --filter=SeedDataTest`

- [X] T016 chore(seed): implement factories and seeders in `database/factories/` and `database/seeders/`
  - Phase: Factories and seeders
  - Dependencies: T015
  - Files: `database/factories/UserFactory.php`, `database/factories/StudentFactory.php`, `database/factories/EvaluationPeriodFactory.php`, `database/factories/EvaluationFormFactory.php`, `database/factories/QuestionCategoryFactory.php`, `database/factories/QuestionFactory.php`, `database/factories/ResponseFactory.php`, `database/factories/ResponseAnswerFactory.php`, `database/seeders/DatabaseSeeder.php`, `database/seeders/SurveyKitaSeeder.php`
  - Expected behavior: Fresh seeding creates demo accounts and academically realistic evaluation data for Universitas Mulia.
  - Acceptance criteria: Seed data includes one admin, several mahasiswa accounts and profiles with NIMs covering multiple known program codes, two periods, several forms, categories for layanan akademik, pembelajaran, fasilitas, administrasi, kepuasan umum, 15-25 questions, and completed responses with suggestions.
  - Verification: `php artisan migrate:fresh --seed && php artisan test --compact --filter=SeedDataTest`

## Phase 10: Evaluation Calculation Service

- [X] T017 test(evaluation): cover Likert calculation rules in `tests/Unit/Services/EvaluationResultServiceTest.php`
  - Phase: Evaluation calculation service
  - Dependencies: T013
  - Files: `tests/Unit/Services/EvaluationResultServiceTest.php`
  - Expected behavior: Result math is zero-safe and maps percentages to the correct Indonesian satisfaction category.
  - Acceptance criteria: Tests cover total respondents, total answers, average score, satisfaction percentage, category mapping, per-category average, per-question average, Likert distribution, suggestions, and no-response empty state.
  - Verification: `php artisan test --compact --filter=EvaluationResultServiceTest`

- [X] T018 feat(evaluation): implement centralized result math in `app/Services/EvaluationResultService.php`
  - Phase: Evaluation calculation service
  - Dependencies: T017
  - Files: `app/Services/EvaluationResultService.php`
  - Expected behavior: Controllers and Blade templates consume result DTO-style arrays from one testable service instead of duplicating business logic.
  - Acceptance criteria: Service calculates total respondents, total answers, average score, satisfaction percentage, satisfaction category, average score per category, average score per question, Likert score distribution, suggestion list, and empty state metadata.
  - Verification: `php artisan test --compact --filter=EvaluationResultServiceTest`

## Phase 11: Admin CRUD Modules

- [X] T019 test(admin): cover admin CRUD and cross-role blocks in `tests/Feature/Admin/AdminCrudTest.php`
  - Phase: Admin CRUD modules
  - Dependencies: T009, T013, T016
  - Files: `tests/Feature/Admin/AdminCrudTest.php`
  - Expected behavior: Admin can manage students, periods, forms, categories, and questions; mahasiswa cannot access those modules.
  - Acceptance criteria: Tests cover create/edit/detail/delete or safe delete for students, periods, forms, categories, and questions, including validation errors and role protection.
  - Verification: `php artisan test --compact --filter=AdminCrudTest`

- [X] T020 feat(admin): implement student and period management in `app/Http/Controllers/Admin/`, `app/Http/Requests/Admin/`, `routes/web.php`, and `resources/views/admin/`
  - Phase: Admin CRUD modules
  - Dependencies: T019
  - Files: `app/Http/Controllers/Admin/DashboardController.php`, `app/Http/Controllers/Admin/StudentController.php`, `app/Http/Controllers/Admin/EvaluationPeriodController.php`, `app/Http/Requests/Admin/StoreStudentRequest.php`, `app/Http/Requests/Admin/UpdateStudentRequest.php`, `app/Http/Requests/Admin/StoreEvaluationPeriodRequest.php`, `app/Http/Requests/Admin/UpdateEvaluationPeriodRequest.php`, `routes/web.php`, `resources/views/admin/dashboard.blade.php`, `resources/views/admin/students/index.blade.php`, `resources/views/admin/students/create.blade.php`, `resources/views/admin/students/edit.blade.php`, `resources/views/admin/students/show.blade.php`, `resources/views/admin/periods/index.blade.php`, `resources/views/admin/periods/create.blade.php`, `resources/views/admin/periods/edit.blade.php`, `resources/views/admin/periods/show.blade.php`
  - Expected behavior: Admin dashboard, student management, and period management are complete with pagination, validation, details, toggles, delete handling, and working navigation.
  - Acceptance criteria: Admin can create mahasiswa users/profiles manually; periods can be activated/deactivated; deleting records with dependent responses/forms is safely blocked with feedback.
  - Verification: `php artisan test --compact --filter=AdminCrudTest`

- [X] T021 feat(admin): implement form, category, and question management in `app/Http/Controllers/Admin/`, `app/Http/Requests/Admin/`, `routes/web.php`, and `resources/views/admin/`
  - Phase: Admin CRUD modules
  - Dependencies: T019, T020
  - Files: `app/Http/Controllers/Admin/EvaluationFormController.php`, `app/Http/Controllers/Admin/QuestionCategoryController.php`, `app/Http/Controllers/Admin/QuestionController.php`, `app/Http/Requests/Admin/StoreEvaluationFormRequest.php`, `app/Http/Requests/Admin/UpdateEvaluationFormRequest.php`, `app/Http/Requests/Admin/StoreQuestionCategoryRequest.php`, `app/Http/Requests/Admin/UpdateQuestionCategoryRequest.php`, `app/Http/Requests/Admin/StoreQuestionRequest.php`, `app/Http/Requests/Admin/UpdateQuestionRequest.php`, `routes/web.php`, `resources/views/admin/forms/index.blade.php`, `resources/views/admin/forms/create.blade.php`, `resources/views/admin/forms/edit.blade.php`, `resources/views/admin/forms/show.blade.php`, `resources/views/admin/categories/index.blade.php`, `resources/views/admin/categories/create.blade.php`, `resources/views/admin/categories/edit.blade.php`, `resources/views/admin/questions/index.blade.php`, `resources/views/admin/questions/create.blade.php`, `resources/views/admin/questions/edit.blade.php`
  - Expected behavior: Admin can create, update, activate/deactivate, inspect, and safely delete forms, categories, and questions with real database persistence.
  - Acceptance criteria: Forms belong to periods, questions belong to forms and categories, required flags and sort order are validated, and all visible admin actions submit to real routes.
  - Verification: `php artisan test --compact --filter=AdminCrudTest`

## Phase 12: Student Profile Completion

- [X] T022 test(student): cover profile completion requirement in `tests/Feature/Student/ProfileCompletionTest.php`
  - Phase: Student profile completion
  - Dependencies: T009, T011, T013, T014
  - Files: `tests/Feature/Student/ProfileCompletionTest.php`
  - Expected behavior: Incomplete mahasiswa profiles can access profile completion and dashboard but cannot submit evaluations.
  - Acceptance criteria: Tests cover missing NIM, unknown program code, parsed study program/year/sequence details, class name, successful profile update, Google-created user with no student profile, and completed profile allowing evaluation fill access.
  - Verification: `php artisan test --compact --filter=ProfileCompletionTest`

- [X] T023 feat(student): implement profile completion controller, request, middleware, and views in `app/Http/Controllers/Student/`, `app/Http/Requests/Student/`, `app/Http/Middleware/`, and `resources/views/student/profile/`
  - Phase: Student profile completion
  - Dependencies: T022
  - Files: `app/Http/Controllers/Student/ProfileController.php`, `app/Http/Requests/Student/UpdateProfileRequest.php`, `app/Http/Middleware/EnsureStudentProfileIsComplete.php`, `bootstrap/app.php`, `routes/web.php`, `resources/views/student/profile/complete.blade.php`
  - Expected behavior: Mahasiswa can complete missing profile data and are redirected there before evaluation submission until complete.
  - Acceptance criteria: NIM is unique when present; profile fields validate clearly; NIM parser fills program code, study program, enrollment year, and sequence number; Google-created users without a profile get a profile row when completing data; admin users cannot use student profile routes.
  - Verification: `php artisan test --compact --filter=ProfileCompletionTest`

## Phase 13: Student Evaluation Flow

- [X] T024 test(student): cover evaluation submission rules in `tests/Feature/Student/EvaluationSubmissionTest.php`
  - Phase: Student evaluation flow
  - Dependencies: T018, T023
  - Files: `tests/Feature/Student/EvaluationSubmissionTest.php`
  - Expected behavior: Mahasiswa can submit one valid response to an active form during an active inclusive period and invalid submissions are blocked.
  - Acceptance criteria: Tests cover active submission, duplicate prevention, inactive form, inactive period, expired period, missing required question, invalid score below 1 or above 5, optional suggestion, and admin blocked from submitting.
  - Verification: `php artisan test --compact --filter=EvaluationSubmissionTest`

- [X] T025 feat(student): implement dashboard, active forms, fill, submit, success, and history flow in `app/Http/Controllers/Student/`, `app/Http/Requests/Student/`, `routes/web.php`, and `resources/views/student/`
  - Phase: Student evaluation flow
  - Dependencies: T024
  - Files: `app/Http/Controllers/Student/DashboardController.php`, `app/Http/Controllers/Student/EvaluationController.php`, `app/Http/Controllers/Student/SubmissionController.php`, `app/Http/Requests/Student/SubmitEvaluationRequest.php`, `routes/web.php`, `resources/views/student/dashboard.blade.php`, `resources/views/student/evaluations/index.blade.php`, `resources/views/student/evaluations/show.blade.php`, `resources/views/student/evaluations/fill.blade.php`, `resources/views/student/submissions/success.blade.php`, `resources/views/student/submissions/index.blade.php`
  - Expected behavior: Mahasiswa sees active forms, submission status, one fillable form at a time, Likert 1-5 options, optional suggestion, success page, and submission history.
  - Acceptance criteria: Submission runs in a transaction; duplicate response uniqueness is handled gracefully; inactive and out-of-period forms cannot be reached or submitted; required questions are enforced; successful submissions redirect to `student.submissions.success`.
  - Verification: `php artisan test --compact --filter=EvaluationSubmissionTest`

## Phase 14: Results Dashboard

- [X] T026 test(admin): cover result dashboard filters and empty states in `tests/Feature/Admin/ResultDashboardTest.php`
  - Phase: Results dashboard
  - Dependencies: T018, T021, T025
  - Files: `tests/Feature/Admin/ResultDashboardTest.php`
  - Expected behavior: Admin result pages show summaries, filters, per-form details, suggestions, and no-response empty states without errors.
  - Acceptance criteria: Tests cover period/form/category filters, total respondents, average score, satisfaction percentage, satisfaction category, per-category recap, per-question recap, suggestions, and admin-only access.
  - Verification: `php artisan test --compact --filter=ResultDashboardTest`

- [X] T027 feat(admin): implement result index and form detail pages in `app/Http/Controllers/Admin/ResultController.php` and `resources/views/admin/results/`
  - Phase: Results dashboard
  - Dependencies: T026
  - Files: `app/Http/Controllers/Admin/ResultController.php`, `routes/web.php`, `resources/views/admin/results/index.blade.php`, `resources/views/admin/results/show.blade.php`, `resources/views/components/summary-card.blade.php`
  - Expected behavior: Admin can view result summaries and detailed recaps powered by `EvaluationResultService`.
  - Acceptance criteria: Result pages use eager loading or aggregate queries; no math is embedded in Blade; empty forms show zero-safe summaries and clear empty states.
  - Verification: `php artisan test --compact --filter=ResultDashboardTest`

## Phase 15: akaunting/laravel-apexcharts Integration

- [X] T028 test(admin): cover chart data wiring in `tests/Feature/Admin/ResultChartsTest.php`
  - Phase: akaunting/laravel-apexcharts integration
  - Dependencies: T027
  - Files: `tests/Feature/Admin/ResultChartsTest.php`
  - Expected behavior: Chart data on result pages reflects seeded or submitted response data rather than hardcoded values.
  - Acceptance criteria: Tests assert chart containers render for overall satisfaction per form, average score per category, respondent count per form, and Likert distribution.
  - Verification: `php artisan test --compact --filter=ResultChartsTest`

- [X] T029 feat(chart): create ApexCharts objects from result data in `app/Http/Controllers/Admin/ResultController.php` and `resources/views/admin/results/`
  - Phase: akaunting/laravel-apexcharts integration
  - Dependencies: T028
  - Files: `app/Http/Controllers/Admin/ResultController.php`, `resources/views/admin/results/index.blade.php`, `resources/views/admin/results/show.blade.php`, `resources/views/components/chart-panel.blade.php`
  - Expected behavior: Admin dashboards render ApexCharts for satisfaction percentage per form, average score per category, respondent count per form, and Likert score distribution.
  - Acceptance criteria: Charts are generated with `akaunting/laravel-apexcharts`; if a real dependency conflict blocks installation, replacement with `arielmejiadev/larapex-charts` is applied consistently in code, plan notes, and task verification.
  - Verification: `php artisan test --compact --filter=ResultChartsTest && bun run build`

## Phase 16: PDF Export

- [X] T030 test(report): cover protected PDF export behavior in `tests/Feature/Exports/PdfExportTest.php`
  - Phase: PDF export
  - Dependencies: T027
  - Files: `tests/Feature/Exports/PdfExportTest.php`
  - Expected behavior: Admin can download a PDF report and non-admin users cannot access it.
  - Acceptance criteria: Tests cover admin download, guest redirect, mahasiswa blocked, report filename, and presence of title, period, total respondents, score summary, category recap, question recap, and suggestions.
  - Verification: `php artisan test --compact --filter=PdfExportTest`

- [X] T031 feat(report): implement DomPDF report export in `app/Http/Controllers/Admin/ReportExportController.php` and `resources/views/pdf/evaluation-report.blade.php`
  - Phase: PDF export
  - Dependencies: T030
  - Files: `app/Http/Controllers/Admin/ReportExportController.php`, `routes/web.php`, `resources/views/pdf/evaluation-report.blade.php`, `config/dompdf.php`
  - Expected behavior: Admin-only PDF export uses `EvaluationResultService` data and a Blade PDF template.
  - Acceptance criteria: PDF includes evaluation title, period, total respondents, average score, satisfaction percentage, satisfaction category, result per category, result per question, and suggestions/comments; empty results export without errors.
  - Verification: `php artisan test --compact --filter=PdfExportTest`

## Phase 17: Excel Export

- [X] T032 test(report): cover protected Excel export behavior in `tests/Feature/Exports/ExcelExportTest.php`
  - Phase: Excel export
  - Dependencies: T027
  - Files: `tests/Feature/Exports/ExcelExportTest.php`
  - Expected behavior: Admin can download a multi-sheet Excel report and non-admin users cannot access it.
  - Acceptance criteria: Tests cover admin download, guest redirect, mahasiswa blocked, report filename, and expected sheets for summary, category recap, question recap, Likert distribution, suggestions, and raw responses.
  - Verification: `php artisan test --compact --filter=ExcelExportTest`

- [X] T033 feat(report): implement Maatwebsite Excel export classes in `app/Exports/`
  - Phase: Excel export
  - Dependencies: T032
  - Files: `app/Exports/EvaluationReportExport.php`, `app/Exports/Sheets/SummarySheet.php`, `app/Exports/Sheets/CategoryRecapSheet.php`, `app/Exports/Sheets/QuestionRecapSheet.php`, `app/Exports/Sheets/LikertDistributionSheet.php`, `app/Exports/Sheets/SuggestionsSheet.php`, `app/Exports/Sheets/RawResponsesSheet.php`, `app/Http/Controllers/Admin/ReportExportController.php`, `routes/web.php`
  - Expected behavior: Admin-only Excel export returns a complete workbook based on service data and raw responses.
  - Acceptance criteria: Workbook includes summary, category recap, question recap, Likert distribution, suggestions, and raw responses sheets; empty results produce zero-safe sheets.
  - Verification: `php artisan test --compact --filter=ExcelExportTest`

## Phase 18: Blade/Tailwind UI Polish

- [X] T034 style(ui): complete responsive Indonesian UI states across `resources/views/auth/`, `resources/views/admin/`, `resources/views/student/`, and `resources/views/components/`
  - Phase: Blade/Tailwind UI polish
  - Dependencies: T005, T007, T020, T021, T025, T027, T029, T031, T033
  - Files: `resources/views/auth/*.blade.php`, `resources/views/admin/**/*.blade.php`, `resources/views/student/**/*.blade.php`, `resources/views/components/*.blade.php`, `resources/css/app.css`
  - Expected behavior: All visible pages are consistent, responsive, accessible, and explainable as custom Blade/Tailwind UI.
  - Acceptance criteria: Indonesian labels are used; tables paginate; buttons and links point to existing named routes; empty, success, validation, and unauthorized states are visible; no card-in-card admin-panel-generator aesthetic is introduced.
  - Verification: `bun run build && php artisan route:list --except-vendor`

- [X] T035 test(ui): cover route, controller, and view wiring in `tests/Feature/UiRouteWiringTest.php`
  - Phase: Blade/Tailwind UI polish
  - Dependencies: T034
  - Files: `tests/Feature/UiRouteWiringTest.php`
  - Expected behavior: Required public, admin, and mahasiswa pages return real responses and visible actions do not target dead routes.
  - Acceptance criteria: Tests cover login, unauthorized feedback, Google rejection feedback, admin dashboard and CRUD pages, result pages, export routes, mahasiswa dashboard, profile completion, active forms, fill page, success page, and submissions page.
  - Verification: `php artisan test --compact --filter=UiRouteWiringTest`

## Phase 19: Pest Tests

- [ ] T036 test(app): complete required behavior regression suite across `tests/Feature/` and `tests/Unit/`
  - Phase: Pest tests
  - Dependencies: T006, T008, T010, T014, T015, T017, T019, T022, T024, T026, T028, T030, T032, T035
  - Files: `tests/Feature/Auth/SessionAuthTest.php`, `tests/Feature/Auth/RoleAccessTest.php`, `tests/Feature/Auth/GoogleOAuthTest.php`, `tests/Feature/Admin/AdminCrudTest.php`, `tests/Feature/Admin/ResultDashboardTest.php`, `tests/Feature/Admin/ResultChartsTest.php`, `tests/Feature/Student/ProfileCompletionTest.php`, `tests/Feature/Student/EvaluationSubmissionTest.php`, `tests/Feature/Exports/PdfExportTest.php`, `tests/Feature/Exports/ExcelExportTest.php`, `tests/Feature/SeedDataTest.php`, `tests/Feature/UiRouteWiringTest.php`, `tests/Feature/ModelAndRelationshipTest.php`, `tests/Unit/Services/NimParserTest.php`, `tests/Unit/Services/EvaluationResultServiceTest.php`
  - Expected behavior: Test suite covers every constitution-required behavior and no test is superficial or empty.
  - Acceptance criteria: Required coverage includes admin access, mahasiswa access, cross-role blocks, login, logout, Google student-domain filtering, NIM parsing, profile completion, admin CRUD, active submission, duplicate prevention, inactive/expired prevention, invalid score rejection, calculation correctness, category mapping, protected PDF export, protected Excel export, seed data, route wiring, and empty result states.
  - Verification: `php artisan test --compact`

- [ ] T037 chore(quality): run Laravel formatting and full backend/frontend verification in `vendor/bin/pint`, `php artisan test`, `bun run build`, and `php artisan route:list`
  - Phase: Pest tests
  - Dependencies: T036
  - Files: `app/**/*.php`, `routes/*.php`, `database/**/*.php`, `tests/**/*.php`, `resources/views/**/*.blade.php`
  - Expected behavior: Code style, tests, asset build, and route registration pass together before completion.
  - Acceptance criteria: Pint formats dirty PHP files; all Pest tests pass; Vite build passes; route list contains all route-contract entries and no dead controller targets.
  - Verification: `vendor/bin/pint --dirty --format agent && php artisan test --compact && bun run build && php artisan route:list --except-vendor`

## Phase 20: README and Verification

- [ ] T038 docs(readme): document fresh-clone setup, demo accounts, and verification commands in `README.md`
  - Phase: README and verification
  - Dependencies: T003, T004, T016, T037
  - Files: `README.md`
  - Expected behavior: A new developer can run SurveyKita locally with Docker Compose MariaDB, Bun assets, migrations, seeders, Pest tests, and `agent-browser` E2E verification.
  - Acceptance criteria: README includes project title, stack, prerequisites, `composer install`, `bun install`, `docker compose up -d`, `cp .env.example .env`, `php artisan key:generate`, `php artisan migrate:fresh --seed`, `bun run build`, `php artisan test`, `php artisan route:list`, `agent-browser` E2E verification notes, Google OAuth env notes, and demo login accounts.
  - Verification: `sed -n '1,240p' README.md`

- [ ] T039 chore(verify): perform final whole-app verification against `specs/001-surveykita-evaluations/quickstart.md`
  - Phase: README and verification
  - Dependencies: T037, T038
  - Files: `specs/001-surveykita-evaluations/quickstart.md`, `README.md`
  - Expected behavior: The documented setup path and complete application flows work from a fresh database.
  - Acceptance criteria: Migration and seeding pass; admin can manage master data and reports; mahasiswa can complete profile and submit one active evaluation; duplicate, inactive, expired, and invalid score submissions fail; charts and exports work; no fake links, placeholder pages, dead routes, or unwired modules remain.
  - Verification: `docker compose up -d && cp .env.example .env && php artisan key:generate && php artisan migrate:fresh --seed && bun run build && php artisan test --compact && php artisan route:list --except-vendor`

- [ ] T040 test(e2e): verify seeded browser workflows with `agent-browser` using `specs/001-surveykita-evaluations/quickstart.md`
  - Phase: README and verification
  - Dependencies: T039
  - Files: `specs/001-surveykita-evaluations/quickstart.md`, `README.md`
  - Expected behavior: A real browser can complete seeded admin and mahasiswa workflows after the Laravel server is running.
  - Acceptance criteria: `agent-browser` verifies login, admin dashboard, student/period/form/category/question navigation, result dashboard, chart rendering, PDF export, Excel export, logout, mahasiswa login, profile completion when needed, active evaluation submission, duplicate submission feedback, submission history, wrong-role blocking, and at least one empty-state result path; snapshots or screenshots are captured as evidence; task-owned browser sessions are closed after verification.
  - Verification: `agent-browser skills get core && php artisan serve --host=127.0.0.1 --port=8000` in one terminal, then use `agent-browser open http://127.0.0.1:8000/login`, `agent-browser snapshot -i`, workflow clicks/fills, screenshots as needed, and `agent-browser close --all`

- [ ] T041 chore(ops): document unattended autonomous execution protocol in `README.md` and `specs/001-surveykita-evaluations/quickstart.md`
  - Phase: README and verification
  - Dependencies: T040
  - Files: `README.md`, `specs/001-surveykita-evaluations/quickstart.md`
  - Expected behavior: The implementation can be run as a long-horizon unattended agent task with no human prompts after start.
  - Acceptance criteria: Documentation states that the agent may install approved dependencies, run non-interactive setup commands, reset and seed the local database, start and stop local services, run Pest, run `agent-browser`, capture verification evidence, clean up task-owned processes, apply targeted fixes, rerun failing gates, and proceed using documented defaults; live Google OAuth credentials are documented as external prerequisites when unavailable.
  - Verification: `rg -n "unattended|autonomous|agent-browser|cleanup|Google OAuth" README.md specs/001-surveykita-evaluations/quickstart.md`

## Dependencies & Execution Order

### Phase Dependencies

1. Project foundation: T001-T002
2. Environment and Docker Compose: T003 depends on dependency alignment
3. Tailwind and Bun frontend setup: T004-T005 depend on frontend dependencies
4. Custom authentication: T006-T007 depend on routes and shared UI
5. Role and authorization system: T008-T009 depend on custom auth
6. Google OAuth login: T010-T011 depend on auth and role routes
7. Database schema: T012 depends on MariaDB configuration
8. Models and relationships: T013-T014 depend on schema
9. Factories and seeders: T015-T016 depend on schema, models, and NIM parser
10. Evaluation calculation service: T017-T018 depend on models
11. Admin CRUD modules: T019-T021 depend on auth, models, and seed data
12. Student profile completion: T022-T023 depend on roles, Google OAuth, models, and NIM parser
13. Student evaluation flow: T024-T025 depend on profile completion and result service
14. Results dashboard: T026-T027 depend on result service, admin modules, and submissions
15. akaunting/laravel-apexcharts integration: T028-T029 depend on result pages
16. PDF export: T030-T031 depend on result pages
17. Excel export: T032-T033 depend on result pages
18. Blade/Tailwind UI polish: T034-T035 depend on implemented views and routes
19. Pest tests: T036-T037 depend on all behavior tests and implementation
20. README and verification: T038-T041 depend on working setup, test suite, browser-level verification, and unattended execution documentation

### User Story Completion Order

- **US1 Admin manages evaluation program**: T019, T020, T021, plus foundation T001-T018.
- **US2 Mahasiswa completes and submits evaluation**: T022, T023, T024, T025, plus foundation T001-T018.
- **US3 Admin reviews results, charts, and reports**: T026, T027, T028, T029, T030, T031, T032, T033, plus US1 and submitted/seeded data.
- **US4 Seeded local demonstration**: T015, T016, T038, T039, T040, T041, plus all feature behavior.

### Parallel Opportunities

- T003 and T004 can run after T001 because Docker and frontend setup touch separate files.
- T006, T008, T010, T014, T015, T017, T019, T022, T024, T026, T028, T030, T032, and T035 are test-writing tasks that can be drafted in parallel after their listed dependencies are available.
- T020 and T021 can be split between student/period CRUD and form/category/question CRUD once T019 exists.
- T031 and T033 can run in parallel after T027 because PDF and Excel exports use separate files.
- T034 can be split by `auth`, `admin`, `student`, and `components` view folders after feature pages exist.
- T040 runs after the final setup and test verification because it depends on a seeded database, built assets, and a running local server.
- T041 follows T040 so the final README and quickstart reflect the real unattended verification protocol.

### Independent Test Criteria

- **US1**: `php artisan test --compact --filter=AdminCrudTest` proves admin can manage students, periods, forms, categories, and questions while mahasiswa is blocked.
- **US2**: `php artisan test --compact --filter=NimParserTest`, `php artisan test --compact --filter=ProfileCompletionTest`, and `php artisan test --compact --filter=EvaluationSubmissionTest` prove NIM parsing, profile gating, and submission rules.
- **US3**: `php artisan test --compact --filter=ResultDashboardTest`, `ResultChartsTest`, `PdfExportTest`, and `ExcelExportTest` prove result summaries, charts, and admin-only reports.
- **US4**: `php artisan migrate:fresh --seed`, `php artisan test --compact --filter=SeedDataTest`, an `agent-browser` seeded workflow run, and unattended execution documentation prove local demo data is complete and browser-demonstrable without human decisions.

## Implementation Strategy

Build only the complete SurveyKita application defined by the constitution and specification. Do not stop after a single role, a single CRUD module, or a narrow evaluation slice.

1. Complete foundation, environment, frontend, auth, role, OAuth, database, models, seeders, and service tasks first.
2. Implement admin CRUD and mahasiswa submission as complete, independently testable role workflows.
3. Implement result dashboards, ApexCharts charts, PDF export, and Excel export from the centralized result service.
4. Finish UI wiring, the full Pest suite, README instructions, `agent-browser` E2E verification, and final verification commands before considering the application complete.

## Guardrails

- Do not install Laravel Breeze, Jetstream, Laravel UI, Filament, Nova, Backpack, Bootstrap, React, Vue, Inertia, Livewire, npm, yarn, or pnpm.
- Do not create routes without controllers, controllers without real responses or Blade views, or views with fake buttons.
- Do not place result calculations in controllers or Blade templates.
- Do not leave TODO comments for core behavior, empty tests, placeholder dashboards, dead routes, orphan controllers, or unused services.
- Do not allow Google OAuth to create or upgrade admin users.
