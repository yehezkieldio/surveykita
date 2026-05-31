<!--
Sync Impact Report
Version change: unratified template -> 1.0.0
Modified principles:
- Template principles -> Complete Whole-App Delivery
- Template principles -> Laravel 13, Blade, and Tailwind Only
- Template principles -> Custom Auth Must Be Clear and Secure
- Template principles -> Google OAuth Is Strictly Student-Only
- Template principles -> Domain Logic Must Be Real, Centralized, and Testable
- Template principles -> Database Integrity First
- Template principles -> Authorization Is Non-Negotiable
- Template principles -> Test-Governed Development
- Template principles -> No Dead Code, Fake UI, or Placeholder Completion
- Template principles -> Report-Friendly Structure
- Template principles -> Local Reproducibility
- Template principles -> Maintainability and Practical Performance
Added sections:
- Required Technology Stack
- Academic Evaluation Domain Rules
- Delivery Workflow and Quality Gates
Removed sections:
- Generic template Section 2
- Generic template Section 3
Templates requiring updates:
- [updated] .specify/templates/plan-template.md
- [updated] .specify/templates/spec-template.md
- [updated] .specify/templates/tasks-template.md
- [updated] .specify/templates/checklist-template.md
- [not present] .specify/templates/commands/*.md
- [updated] AGENTS.md
Follow-up Items:
- README.md still contains the default Laravel starter content. Implementation work MUST replace it
  with SurveyKita setup instructions, demo accounts, and local verification commands.
-->

# SurveyKita Constitution

## Core Principles

### I. Complete Whole-App Delivery

SurveyKita MUST be delivered as a complete working Laravel application, not an
MVP, prototype, narrow slice, starter-kit demo, admin-panel shortcut, or partial
scaffold. Every planned route MUST have a controller. Every controller action
MUST return a real response or Blade view. Every visible button MUST lead to
working behavior. Every core feature MUST be demonstrable locally.

The final application MUST include custom authentication, role-based access,
Google OAuth login for mahasiswa, admin CRUD modules, student evaluation
submission, Likert calculation, result dashboards, charts, PDF export, Excel
export, seed data, Pest tests, Docker Compose MariaDB local development, and
README setup instructions.

Rationale: The project is an academic information system and must be complete
enough to support demonstration, testing, reporting, UML, ERD, and final defense.

### II. Laravel 13, Blade, and Tailwind Only

SurveyKita MUST use Laravel 13 with PHP 8.3 or newer, Laravel Blade, Tailwind
CSS, Bun, Vite, MariaDB, Docker Compose for local MariaDB, Pest, Laravel
Socialite, akaunting/laravel-apexcharts, a Laravel-compatible PDF package such
as DomPDF, and Maatwebsite Excel.

SurveyKita MUST NOT use Laravel Breeze, Jetstream, Laravel UI, Filament, Nova,
Backpack, React, Vue, Inertia, Bootstrap, SQLite as the main local development
database, npm, yarn, pnpm, or admin panel generators. Livewire MUST NOT be used
unless a later constitution amendment explicitly permits it.

Rationale: The UI and architecture must remain explainable in a university
report and must not depend on generated admin panels or frontend frameworks that
obscure the application flow.

### III. Custom Auth Must Be Clear and Secure

Authentication MUST be implemented manually using Laravel built-in
authentication primitives. The application MUST include a login page, login
submission, logout, password hashing, session regeneration on login, session
invalidation on logout, auth middleware route protection, role middleware for
admin and mahasiswa, Form Request validation, clear error messages, and safe
role-based redirects after login.

Registration SHOULD be disabled by default. Admin users MAY create mahasiswa
accounts manually. Google OAuth MAY create mahasiswa users, but it MUST never
create admin users.

Rationale: Auth is a core academic workflow and must be understandable,
auditable, and testable without starter-kit scaffolding.

### IV. Google OAuth Is Strictly Student-Only

Google OAuth MUST use Laravel Socialite. The OAuth flow MUST redirect to Google,
handle callbacks safely, normalize email addresses to lowercase, allow only
emails ending with `@students.universitasmulia.ac.id`, reject every other email
domain, and create or link only mahasiswa accounts.

Google OAuth MUST never create admin accounts. Mahasiswa users with incomplete
profiles MUST be redirected to profile completion. Evaluation submission MUST be
blocked until required profile data is complete.

Rationale: Google login is for student identity only. Admin access must remain
explicitly provisioned and separate from external OAuth.

### V. Domain Logic Must Be Real, Centralized, and Testable

Evaluation scoring MUST NOT be scattered across controllers, Blade templates, or
ad hoc query fragments. Calculation logic MUST live in a dedicated service class,
such as `EvaluationResultService`, and MUST be covered by focused Pest tests.

The service MUST calculate total respondents, total answers, average score,
satisfaction percentage, satisfaction category, average score per category,
average score per question, Likert score distribution, and suggestion or comment
lists.

SurveyKita MUST enforce these academic evaluation rules:

- A mahasiswa can submit only one response per evaluation form.
- Scores MUST be integers from 1 to 5.
- Inactive forms MUST NOT be submitted.
- Expired periods MUST NOT be submitted.
- Inactive periods MUST NOT be submitted.
- Required questions MUST be answered.
- Students with incomplete profile data MUST NOT submit evaluations.

Rationale: Academic evaluation results must be reproducible, explainable, and
verifiable independently from presentation code.

### VI. Database Integrity First

The database schema MUST enforce important invariants using foreign keys, unique
constraints, indexes, and validation together. Application validation alone is
not sufficient.

Required integrity rules:

- `users.email` MUST be unique.
- `students.user_id` MUST be unique.
- `students.nim` MUST be unique.
- `responses` MUST be unique by `evaluation_form_id` and `student_id`.
- `response_answers` MUST be unique by `response_id` and `question_id`.
- `response_answers.score` MUST be constrained to 1-5 where MariaDB supports it.
- All core relationships MUST have foreign keys.
- Reporting and filtering columns MUST have useful indexes.

Rationale: The database is the final guardrail for academic records, duplicate
submissions, and report correctness.

### VII. Authorization Is Non-Negotiable

The system has exactly two roles unless this constitution is amended: `admin`
and `mahasiswa`. Admin routes MUST be inaccessible to mahasiswa. Mahasiswa-only
routes MUST be inaccessible to admin unless explicitly shared. Export routes,
result routes, and dashboard result views MUST be admin-only. Evaluation
submission routes MUST be mahasiswa-only.

Unauthorized access MUST fail safely with clear feedback and without leaking
private data.

Rationale: Academic evaluation data and exports are administrative records, while
submission belongs to students only.

### VIII. Test-Governed Development

SurveyKita MUST include Pest tests for real behavior, not superficial status-code
checks. The project is not complete unless the test suite passes.

Tests MUST cover admin access, mahasiswa access, blocked cross-role access,
login, logout, Google student-domain filtering, profile completion requirements,
admin CRUD behavior, active evaluation submission, duplicate submission
prevention, inactive form prevention, expired period prevention, invalid score
rejection, calculation correctness, satisfaction category mapping, protected PDF
export, and protected Excel export.

Rationale: Tests are the proof that the whole application works locally and that
future agents have not drifted into placeholder completion.

### IX. No Dead Code, Fake UI, or Placeholder Completion

Implementation MUST NOT leave TODO comments for core behavior, fake buttons,
unwired pages, orphan controllers, dead routes, unused services, empty tests,
placeholder dashboards, or views that pretend a feature exists without actually
implementing it.

Every generated module MUST be wired through migration, model, relationship,
request validation, controller, route, Blade view, authorization, and relevant
test coverage.

Rationale: A visible feature that is not wired to working behavior is a project
failure, not a partial success.

### X. Report-Friendly Structure

SurveyKita MUST use readable domain names that are easy to explain in a
proposal, UML, ERD, activity diagram, and final report. Core tables and concepts
MUST use names such as `users`, `students`, `evaluation_periods`,
`evaluation_forms`, `question_categories`, `questions`, `responses`, and
`response_answers`.

Unnecessary architecture patterns MUST be avoided when they make the report
harder to explain. The project SHOULD use Laravel conventions, clear service
classes for real domain logic, Form Requests for validation, policies or
middleware for authorization, and simple Blade views.

Rationale: The implementation must be technically sound and explainable by a
university group.

### XI. Local Reproducibility

A fresh clone MUST be able to run locally using documented commands. The project
MUST include `docker-compose.yml` for MariaDB, `.env.example` configured for
local MariaDB, README setup instructions, migration and seeder flow, Bun
frontend setup, build command, Pest test command, and demo login accounts.

Rationale: Local reproducibility is required for grading, demonstrations,
handoff, and reliable agent verification.

### XII. Maintainability and Practical Performance

SurveyKita MUST use pagination for tables, indexes for filtering and reporting,
eager loading where needed, transactions for response submission, and query
patterns that avoid N+1 issues in dashboards and reports.

The implementation MUST avoid god controllers, god services, deeply nested
abstractions, duplicated query logic, and business logic inside Blade templates.

Rationale: The app must remain maintainable for a student team while still
handling realistic academic evaluation data.

## Required Technology Stack

All specifications, plans, tasks, and implementations MUST preserve this stack:

- Laravel 13 and PHP 8.3 or newer.
- Laravel Blade for all server-rendered pages.
- Tailwind CSS and Vite for styling and asset bundling.
- Bun for JavaScript package management and frontend commands.
- MariaDB as the local development database through Docker Compose.
- Pest for automated testing.
- Laravel Socialite for Google OAuth.
- akaunting/laravel-apexcharts for chart rendering.
- DomPDF or an equivalent Laravel PDF package for PDF export.
- Maatwebsite Excel for Excel export.

Any proposed dependency change MUST be justified against the constitution and
approved before implementation.

## Academic Evaluation Domain Rules

The application domain is student satisfaction evaluation for academic services.
Specifications MUST model admin-managed evaluation periods, forms, question
categories, questions, student profiles, responses, response answers, score
calculation, dashboards, charts, and exports as first-class features.

Generated artifacts MUST NOT reduce the system to generic CRUD. CRUD modules are
required for administration, but the central product is the validated mahasiswa
evaluation flow and the resulting academic reporting.

## Delivery Workflow and Quality Gates

Before implementation, every generated specification, clarification, plan, task
list, analysis, and implementation decision MUST be checked against this
constitution. If any generated artifact conflicts with this constitution, this
constitution wins.

Planning MUST include explicit gates for complete route-controller-view wiring,
authorization, database integrity, domain service coverage, Pest tests, exports,
charts, seed data, and local reproducibility. Task generation MUST include real
file paths and must not leave placeholder work for core behavior.

Implementation is complete only when:

- All planned pages, buttons, forms, routes, controllers, and views are wired.
- Required seed data and demo accounts exist.
- `bun` asset commands are documented and usable.
- MariaDB local setup is documented and usable.
- Pest tests pass.
- PDF and Excel exports are protected and functional.
- README setup instructions are accurate for a fresh clone.

## Governance

This constitution supersedes all generated specifications, plans, tasks,
implementation shortcuts, and agent assumptions. Amendments require an explicit
user request or approval, a Sync Impact Report in this file, and updates to
dependent Spec Kit templates when the amendment changes planning, specification,
task, or verification expectations.

Versioning follows semantic versioning:

- MAJOR: Backward-incompatible governance changes, removal of core principles,
  or a technology-stack change that invalidates existing specs or plans.
- MINOR: New principles, new required sections, or materially expanded
  governance.
- PATCH: Clarifications, wording fixes, or non-semantic refinements.

Compliance review is mandatory during specification, clarification, planning,
task generation, analysis, implementation, and final verification. Generated
artifacts MUST explicitly surface conflicts instead of silently weakening these
rules.

**Version**: 1.0.0 | **Ratified**: 2026-05-31 | **Last Amended**: 2026-05-31
