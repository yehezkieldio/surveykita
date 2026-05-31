---

description: "Task list template for SurveyKita feature implementation"
---

# Tasks: [FEATURE NAME]

**Input**: Design documents from `/specs/[###-feature-name]/`

**Prerequisites**: plan.md (required), spec.md (required for user stories),
research.md, data-model.md, contracts/

**Tests**: Pest tests are REQUIRED for SurveyKita behavior. Do not generate empty
tests or superficial status-only checks for protected workflows.

**Organization**: Tasks are grouped by complete SurveyKita user story while
preserving whole-app delivery. Priorities guide sequencing; they do not permit
shipping an MVP-only slice when the constitution requires a complete app.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependencies)
- **[Story]**: Which user story this task belongs to (e.g., US1, US2, US3)
- Include exact Laravel file paths in descriptions

## Path Conventions

- Controllers: `app/Http/Controllers/`
- Form Requests: `app/Http/Requests/`
- Middleware: `app/Http/Middleware/`
- Models: `app/Models/`
- Policies: `app/Policies/`
- Services: `app/Services/`
- Migrations: `database/migrations/`
- Factories: `database/factories/`
- Seeders: `database/seeders/`
- Blade views: `resources/views/`
- Routes: `routes/web.php` and `routes/auth.php`
- Tests: `tests/Feature/` and `tests/Unit/`

<!--
  The /speckit-tasks command MUST replace these sample tasks with actual tasks
  based on spec.md, plan.md, data-model.md, contracts/, and the SurveyKita
  Constitution.

  Tasks MUST NOT leave fake UI, TODO-only behavior, orphan controllers, dead
  routes, empty tests, placeholder dashboards, or unwired scaffolds.
-->

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Project dependencies, environment, and local reproducibility

- [ ] T001 Configure allowed Laravel dependencies in composer.json for Socialite,
  ApexCharts, PDF export, and Excel export
- [ ] T002 Configure Bun/Vite/Tailwind asset workflow in package.json and
  frontend assets
- [ ] T003 Add Docker Compose MariaDB service in docker-compose.yml
- [ ] T004 Update .env.example for local MariaDB, Google OAuth placeholders, and
  mail/session settings
- [ ] T005 Add README setup, migration, seeder, Bun build, test commands, and
  demo accounts

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Core infrastructure that MUST be complete before user-story work

**CRITICAL**: No user story work can begin until this phase is complete.

- [ ] T006 Create/adjust migrations for users, students, evaluation_periods,
  evaluation_forms, question_categories, questions, responses, and
  response_answers with foreign keys, unique constraints, and indexes
- [ ] T007 Create Eloquent models, relationships, factories, and seeders for core
  SurveyKita entities
- [ ] T008 Implement custom login/logout controllers, routes, Blade views, and
  Form Requests
- [ ] T009 Implement admin and mahasiswa role middleware and route groups
- [ ] T010 Implement Google OAuth redirect/callback flow with student-domain
  filtering and mahasiswa-only creation/linking
- [ ] T011 Implement profile completion gating for mahasiswa submission routes
- [ ] T012 Create base Blade layout, navigation, flash/error feedback, and
  Tailwind UI primitives without Bootstrap or frontend frameworks
- [ ] T013 Add Pest tests for login, logout, role access, blocked cross-role
  access, OAuth domain filtering, and profile completion requirement

**Checkpoint**: Foundation ready. Auth, roles, database invariants, and local
setup are demonstrable before feature stories continue.

---

## Phase 3: User Story 1 - [Title] (Priority: P1)

**Goal**: [Brief description of the complete SurveyKita workflow delivered.]

**Independent Test**: [How Pest and/or local browser use proves this workflow
works with real data, routes, controllers, Blade views, authorization, and
validation.]

### Tests for User Story 1

> Write these tests before or alongside implementation and verify they fail for
> missing behavior before completing the story.

- [ ] T014 [P] [US1] Add feature test for [authorized happy path] in
  tests/Feature/[Name]Test.php
- [ ] T015 [P] [US1] Add feature test for [blocked/invalid path] in
  tests/Feature/[Name]Test.php

### Implementation for User Story 1

- [ ] T016 [P] [US1] Create or update migration/model/factory/seeder for
  [entity] in database/ and app/Models/
- [ ] T017 [P] [US1] Create Form Request validation for [action] in
  app/Http/Requests/
- [ ] T018 [US1] Implement controller actions in app/Http/Controllers/
- [ ] T019 [US1] Register named routes with auth and role middleware in routes/
- [ ] T020 [US1] Create Blade views in resources/views/ with working forms,
  links, buttons, validation errors, and success feedback
- [ ] T021 [US1] Add authorization checks through middleware or policy
- [ ] T022 [US1] Verify no fake buttons, dead routes, placeholder content, or
  TODO-only core behavior remain for this story

**Checkpoint**: User Story 1 is fully functional and independently testable.

---

## Phase 4: User Story 2 - [Title] (Priority: P2)

**Goal**: [Brief description of the complete SurveyKita workflow delivered.]

**Independent Test**: [How to verify this story works independently.]

### Tests for User Story 2

- [ ] T023 [P] [US2] Add feature test for [authorized happy path] in
  tests/Feature/[Name]Test.php
- [ ] T024 [P] [US2] Add feature test for [blocked/invalid path] in
  tests/Feature/[Name]Test.php

### Implementation for User Story 2

- [ ] T025 [P] [US2] Create or update domain files for [entity/service/view]
- [ ] T026 [US2] Implement controller, request validation, routes, Blade views,
  authorization, and seeded data for [workflow]
- [ ] T027 [US2] Integrate with prior SurveyKita workflows without duplicating
  query or domain logic

**Checkpoint**: User Stories 1 and 2 both work with role boundaries enforced.

---

## Phase 5: User Story 3 - [Title] (Priority: P3)

**Goal**: [Brief description of the complete SurveyKita workflow delivered.]

**Independent Test**: [How to verify this story works independently.]

### Tests for User Story 3

- [ ] T028 [P] [US3] Add feature or unit test for [calculation/export/dashboard]
  in tests/
- [ ] T029 [P] [US3] Add protected access test for [admin-only/mahasiswa-only]
  route in tests/Feature/

### Implementation for User Story 3

- [ ] T030 [US3] Implement centralized service logic in app/Services/ when
  calculation or report behavior is involved
- [ ] T031 [US3] Implement dashboard/chart/export controller actions and Blade
  views with real data
- [ ] T032 [US3] Protect result, PDF, and Excel export routes as admin-only

**Checkpoint**: All user stories are independently functional and integrated.

---

[Add more user story phases as needed.]

---

## Phase N: Polish & Cross-Cutting Concerns

**Purpose**: Constitution compliance, quality, and reproducibility checks

- [ ] TXXX Run `vendor/bin/pint --dirty --format agent` if PHP files changed
- [ ] TXXX Run `php artisan test --compact`
- [ ] TXXX Run Bun build command documented in README
- [ ] TXXX Verify all named routes resolve to controllers and real responses
- [ ] TXXX Verify every visible button/link has working behavior
- [ ] TXXX Verify dashboards avoid known N+1 query paths
- [ ] TXXX Verify PDF and Excel exports are admin-only and functional
- [ ] TXXX Verify README fresh-clone setup instructions with Docker Compose
- [ ] TXXX Remove fake UI, empty tests, TODO-only core behavior, dead routes, and
  unused services

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies - can start immediately
- **Foundational (Phase 2)**: Depends on Setup completion and blocks all user
  stories
- **User Stories (Phase 3+)**: Depend on Foundational completion
- **Polish (Final Phase)**: Depends on all planned user stories being complete

### User Story Dependencies

- User stories may be sequenced by priority, but the final task list MUST still
  cover complete whole-app delivery.
- Cross-story dependencies MUST be explicit and MUST NOT create fake UI or
  unwired routes while waiting for later work.

### Within Each User Story

- Tests before or alongside implementation, with failure observed for missing
  behavior where practical
- Migrations/models before request validation and controllers
- Services before controllers when domain calculation is involved
- Routes/controllers/views/authorization wired together before story checkpoint
- Story complete before it is marked done

### Parallel Opportunities

- Independent migrations, models, factories, and seeders may run in parallel
- Independent Form Requests and Blade views may run in parallel
- Tests for different user stories may run in parallel
- Avoid parallel edits to the same route, layout, or service file

---

## Implementation Strategy

### Constitution-First Delivery

1. Complete Setup and Foundational phases.
2. Implement prioritized user stories with real tests and real UI wiring.
3. Complete dashboards, charts, PDF export, Excel export, seed data, and README.
4. Run the documented quality gates.
5. Do not mark the project complete until the Pest suite passes.

### Team Strategy

With multiple developers:

1. Team completes Setup and Foundation together.
2. Split user stories by route/view/controller ownership.
3. Coordinate shared files such as routes, layout, seeders, and services.
4. Integrate only when tests and visible workflows pass locally.

---

## Notes

- [P] tasks = different files, no dependencies
- [Story] label maps task to a user story for traceability
- Use Laravel artisan generators where appropriate
- Use Bun, not npm/yarn/pnpm
- Keep business logic out of Blade templates
- Keep calculation logic in service classes
- Avoid admin panel generators and starter kits
