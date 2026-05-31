# Implementation Plan: [FEATURE]

**Branch**: `[###-feature-name]` | **Date**: [DATE] | **Spec**: [link]

**Input**: Feature specification from `/specs/[###-feature-name]/spec.md`

**Note**: This template is filled in by the `/speckit-plan` command. See
`.specify/templates/plan-template.md` for the execution workflow.

## Summary

[Extract from feature spec: SurveyKita academic evaluation requirement,
affected roles, user-facing behavior, and technical approach.]

## Technical Context

**Language/Version**: PHP 8.3+ with Laravel 13

**Primary Dependencies**: Laravel Blade, Tailwind CSS, Vite, Laravel Socialite,
akaunting/laravel-apexcharts, DomPDF or equivalent Laravel PDF package,
Maatwebsite Excel

**Storage**: MariaDB through Docker Compose for local development

**Testing**: Pest feature and unit tests

**Target Platform**: Local web application served by Laravel

**Project Type**: Laravel Blade web application

**Performance Goals**: Paginated admin tables, eager-loaded dashboards, indexed
reporting filters, and no known N+1 query paths in result views

**Constraints**: Must use custom auth, admin/mahasiswa role separation, Bun for
JavaScript package management, Blade/Tailwind UI, MariaDB, and no starter kits,
admin panel generators, React, Vue, Inertia, Bootstrap, npm, yarn, pnpm, or
SQLite as the main local development database

**Scale/Scope**: Complete SurveyKita application covering authentication,
student-only Google OAuth, admin CRUD, evaluation submission, Likert
calculation, dashboards, charts, PDF export, Excel export, seed data, tests, and
fresh-clone setup instructions

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- Whole-app delivery: Every planned route has a controller, response or Blade
  view, visible UI action, authorization rule, and test coverage where relevant.
- Stack compliance: Plan uses Laravel 13, Blade, Tailwind, Bun, Vite, MariaDB,
  Pest, Socialite, ApexCharts, PDF export, and Excel export. No banned starter
  kits, frontend frameworks, package managers, admin panels, or SQLite main DB.
- Auth and authorization: Plan includes manual auth primitives, role middleware,
  Form Requests, safe redirects, protected routes, and two-role boundaries.
- Google OAuth: Plan restricts OAuth to mahasiswa with lowercase
  `@students.universitasmulia.ac.id` email addresses and blocks incomplete
  student profiles from submission.
- Domain logic: Plan centralizes result calculation in a service such as
  `EvaluationResultService` and covers all required Likert metrics.
- Database integrity: Plan includes foreign keys, unique constraints, score
  constraints where MariaDB supports them, and useful reporting indexes.
- Testing: Plan includes Pest tests for access, auth, OAuth domain filtering,
  profile completion, CRUD, submission rules, calculation correctness, and
  protected exports.
- No placeholders: Plan rejects fake buttons, orphan routes, empty tests,
  placeholder dashboards, TODO-only core behavior, and unwired scaffolds.
- Reproducibility: Plan includes Docker Compose MariaDB, `.env.example`,
  migration/seeder flow, Bun commands, build command, test command, and demo
  accounts for README coverage.

## Project Structure

### Documentation (this feature)

```text
specs/[###-feature]/
├── plan.md              # This file (/speckit-plan command output)
├── research.md          # Phase 0 output (/speckit-plan command)
├── data-model.md        # Phase 1 output (/speckit-plan command)
├── quickstart.md        # Phase 1 output (/speckit-plan command)
├── contracts/           # Phase 1 output, if external/API contracts are needed
└── tasks.md             # Phase 2 output (/speckit-tasks command)
```

### Source Code (repository root)

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Policies/
└── Services/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
├── web.php
└── auth.php

tests/
├── Feature/
└── Unit/

docker-compose.yml
README.md
```

**Structure Decision**: [Document the real Laravel directories touched by this
feature and explain how the plan preserves the constitution.]

## Complexity Tracking

> **Fill ONLY if Constitution Check has violations that must be justified**

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [e.g., extra package] | [current need] | [why Laravel built-in path is insufficient] |
