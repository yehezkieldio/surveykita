# Research: SurveyKita Academic Evaluation System

## Decision: Use manual Laravel session authentication

**Rationale**: The constitution bans Breeze, Jetstream, Laravel UI, and admin
panel generators. Laravel 13 documentation supports manual authentication with
`Auth::attempt`, session regeneration after login, and normal session
invalidation on logout. This keeps authentication explainable for a university
report and avoids starter-kit scaffolding.

**Alternatives considered**:

- Laravel Breeze: rejected by constitution.
- Jetstream or Laravel UI: rejected by constitution.
- OAuth-only login: rejected because admin-created mahasiswa accounts and admin
  password login are required.

## Decision: Use one `users` table with explicit `role`

**Rationale**: The system has exactly two roles, `admin` and `mahasiswa`. One
user model with role helper methods keeps auth simple and report-friendly.
Role middleware enforces route boundaries.

**Alternatives considered**:

- Separate guards/tables for admin and mahasiswa: more complex than needed and
  harder to explain in the final report.
- Permission package: unnecessary for two fixed roles.

## Decision: Google OAuth creates or links mahasiswa only

**Rationale**: Laravel Socialite supports redirect/callback routes, user detail
retrieval, authentication of existing users, and testing through Socialite fakes.
SurveyKita must lowercase email, accept only
`@students.universitasmulia.ac.id`, store `google_id`, never create admin users,
and redirect incomplete profiles to completion.

**Alternatives considered**:

- Allow all Google accounts: violates student-only rule.
- Use Google hosted-domain hint as the only control: insufficient because the
  callback email still must be validated server-side.
- Create student profile automatically with all fields: rejected because NIM and
  academic details still require confirmation/completion.

## Decision: Use MariaDB with database constraints and application validation

**Rationale**: The constitution requires MariaDB and database integrity first.
Foreign keys, unique constraints, nullable unique NIM, composite response
uniqueness, and composite answer uniqueness protect academic records even if a
controller path changes later. Application validation provides user-friendly
feedback.

**Alternatives considered**:

- SQLite local database: rejected by constitution.
- Validation-only constraints: rejected because database integrity is required.

## Decision: Centralize calculations in `EvaluationResultService`

**Rationale**: Result calculations are domain logic and must not be scattered
through controllers or Blade templates. One service gives dashboards, charts,
PDF, Excel, and tests the same source of truth.

**Alternatives considered**:

- Controller-level calculations: rejected because it creates duplication and
  testing friction.
- SQL-only views: rejected as less explainable for a Laravel student project and
  harder to pair with zero-safe output.

## Decision: Use akaunting/laravel-apexcharts first

**Rationale**: The constitution and user request require
akaunting/laravel-apexcharts as the primary chart package. ApexCharts supports
bar/column style series for category averages, respondent counts, and Likert
distribution, plus percentage-oriented visualizations for satisfaction by form.

**Fallback**: If Composer reports a real dependency conflict, use
arielmejiadev/larapex-charts and update all chart package references in the plan
and tasks consistently.

**Alternatives considered**:

- Hand-written chart JavaScript: rejected because the required package exists in
  the project contract.
- React/Vue chart wrappers: rejected by constitution.

## Decision: Use DomPDF with Blade PDF templates

**Rationale**: Laravel DomPDF supports loading Blade views with data and
downloading generated PDFs. A Blade PDF template keeps report layout consistent
with server-rendered Laravel and easy to explain.

**Alternatives considered**:

- Browser print-only reports: not a real PDF export.
- External PDF service: unnecessary dependency for local university project.

## Decision: Use Maatwebsite Excel multi-sheet exports

**Rationale**: Laravel Excel supports export classes, mapping/headings, query or
collection exports, and download responses. Multi-sheet export classes match the
required summary, category recap, question recap, Likert distribution,
suggestions, and raw response sheets.

**Alternatives considered**:

- CSV-only export: insufficient because multiple sheets are required.
- Manual PhpSpreadsheet usage in controllers: rejected because export classes
  are cleaner and testable.

## Decision: Use Pest feature and unit tests

**Rationale**: The project already uses Pest 4 and pest-plugin-laravel. Feature
tests cover auth, roles, CRUD, submissions, profile gates, protected exports,
and Socialite fakes. Unit tests cover `EvaluationResultService` calculations and
category mapping.

**Alternatives considered**:

- PHPUnit-style tests only: not aligned with project setup.
- Superficial status-code-only tests: rejected by constitution.

## Decision: Keep contracts as route/UI/report contracts

**Rationale**: SurveyKita is a Blade web application, not a public API. Contract
artifacts should describe route ownership, request/response expectations, UI
surface requirements, and export contents so tasks can be generated without
inventing an API layer.

**Alternatives considered**:

- OpenAPI contract: unnecessary and potentially misleading for a server-rendered
  web application.
- No contracts: would leave route and export behavior less traceable.
