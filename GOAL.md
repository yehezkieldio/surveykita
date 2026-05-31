# SurveyKita Whole-App Implementation Goal

This is an execution contract, not a replacement product specification. The
objective is to implement the complete SurveyKita Spec Kit task set from the
current repository and GitHub Issues, keep evidence current during the run, and
make an autonomous final completion decision without requiring human input.

## Goal Statement

Implement the entire SurveyKita Laravel 13 academic evaluation information
system defined by Spec Kit and tracked by GitHub Issues `#1` through `#41`.

Do not stop after one issue, one role, one CRUD module, one vertical slice, an
MVP, a prototype, a starter-kit scaffold, or a visually plausible but unwired
UI. The goal is complete whole-app delivery: every planned route, controller,
view, button, workflow, calculation, export, seed, and test must be real,
locally demonstrable, and verified.

## End State

The goal is complete only when all of the following are true:

- GitHub Issues `#1` through `#41` are implemented, verified, and closed or are
  clearly documented as intentionally superseded by an equivalent completed
  issue with evidence.
- The root working tree contains a complete Laravel 13 SurveyKita application:
  custom auth, role access, Google OAuth for mahasiswa, admin CRUD modules,
  student profile completion, student evaluation submission, Likert result
  calculation, result dashboard, charts, PDF export, Excel export, seed data,
  Pest tests, Docker Compose MariaDB, Bun/Vite/Tailwind assets, and README
  setup instructions.
- No banned stack or shortcut is introduced: no Breeze, Jetstream, Laravel UI,
  Filament, Nova, Backpack, Bootstrap, React, Vue, Inertia, Livewire, SQLite as
  the main local database, npm, yarn, pnpm, or admin panel generator.
- Every visible action points to a real route and behavior. There are no fake
  buttons, placeholder dashboards, dead routes, orphan controllers, empty
  tests, unwired pages, or TODO comments for core behavior.
- The required verification gates pass and are recorded in
  `.spec/goal/implementation-report.md`.
- The final report contains enough evidence for another agent or human to audit
  what was implemented, what was verified, which commits closed which issues,
  and whether SurveyKita is complete.

If any required item cannot be completed, SurveyKita is not complete. Record the
exact blocker, the attempted fixes, and the next required action in the report.

## Source Of Truth

Read these before implementation and keep them aligned during the run:

1. `AGENTS.md`
2. `GOAL.md`
3. `.specify/memory/constitution.md`
4. `specs/001-surveykita-evaluations/spec.md`
5. `specs/001-surveykita-evaluations/plan.md`
6. `specs/001-surveykita-evaluations/tasks.md`
7. `specs/001-surveykita-evaluations/data-model.md`
8. `specs/001-surveykita-evaluations/research.md`
9. `specs/001-surveykita-evaluations/contracts/route-contract.md`
10. `specs/001-surveykita-evaluations/contracts/ui-contract.md`
11. `specs/001-surveykita-evaluations/contracts/report-contract.md`
12. `specs/001-surveykita-evaluations/quickstart.md`
13. GitHub Issues in `yehezkieldio/surveykita` labeled `speckit` and
    `laravel`, especially `#1` through `#41`
14. Existing Laravel project files and package versions in this repository

Conflict rules:

- The constitution wins over every generated artifact.
- The feature specification defines behavior and acceptance.
- The plan, data model, contracts, quickstart, and tasks define the technical
  implementation shape.
- GitHub Issues mirror `tasks.md` and are the implementation-tracking units.
- `GOAL.md` governs execution process: reporting, commits, issue closure,
  verification, stop conditions, and final completion decision.
- If artifacts disagree, repair the smallest affected artifact or
  implementation surface before continuing. Do not paper over contradictions.

## Fixed Operator Decisions

- Work unattended. The human is not available during the run. Use documented
  defaults and make informed engineering decisions from the source-of-truth
  artifacts instead of asking for preferences.
- Implement the whole Spec Kit task set, not only one issue or one slice.
- Use Laravel 13, PHP 8.3 or newer, Blade, Tailwind CSS, Bun, Vite, MariaDB,
  Docker Compose, custom Laravel session auth, Laravel Socialite,
  `akaunting/laravel-apexcharts`, DomPDF or compatible Laravel PDF package,
  Maatwebsite Excel, Pest, and pest-plugin-laravel.
- Use `akaunting/laravel-apexcharts` as the primary chart package. If it cannot
  be installed because of a real dependency conflict, use
  `arielmejiadev/larapex-charts` consistently and update code, plan notes,
  report, and verification evidence.
- Use Bun for JavaScript package management. Do not use npm, yarn, or pnpm.
- Use MariaDB for local development through Docker Compose. Do not use SQLite
  as the main local development database.
- Public registration remains disabled unless the Spec Kit artifacts are
  amended. Admin can manually create mahasiswa accounts and profiles. Google
  OAuth can create mahasiswa users only and must never create admin users.
- Google OAuth accepts only lowercase emails ending with
  `@students.universitasmulia.ac.id`. `GOOGLE_CLIENT_ID`,
  `GOOGLE_CLIENT_SECRET`, and `GOOGLE_REDIRECT_URI` are expected in local
  `.env`; never print, commit, or report secret values.
- The Google callback route must be `/auth/google/callback`. If `.env` drifts,
  correct it locally without exposing secrets.
- Live Google browser login may be blocked by account challenge, MFA, consent,
  CAPTCHA, or missing real student account. That is not a goal blocker if
  Socialite fake tests pass and seeded mahasiswa password accounts verify the
  local browser workflow.
- Student NIM parsing is required. A valid NIM is `TTAABBB`, for example
  `2311032` -> enrollment year `2023`, program code `11`,
  `S1 Informatika`, sequence `032`.
- Keep `.spec/goal/implementation-report.md` updated during the run, not only
  at the end.
- Use `agent-browser` for final browser-level E2E verification after Pest,
  build, seed, and route gates pass. Close task-owned browser sessions and
  report cleanup evidence.

## Implementation Tracks

Proceed in dependency order unless a focused test or independent file group can
be safely parallelized.

### Track 1: Foundation, Environment, And UI Base

Issues: `#1` through `#5`

- Align approved Composer and Bun dependencies.
- Register route files, middleware aliases, and providers.
- Configure Docker Compose MariaDB and `.env.example`.
- Configure Bun, Vite, Tailwind, and asset entrypoints.
- Create shared Blade layouts and reusable components.

### Track 2: Authentication, Authorization, And Google OAuth

Issues: `#6` through `#11`

- Write and pass custom login/logout tests.
- Implement manual Laravel session login/logout without Breeze.
- Write and pass admin/mahasiswa route-boundary tests.
- Implement role middleware and protected route groups.
- Write and pass Google OAuth domain-filtering tests.
- Implement student-only Google OAuth with Socialite and rejection feedback.

### Track 3: Schema, Models, Seed Data, And Domain Services

Issues: `#12` through `#18`

- Create migrations with foreign keys, unique constraints, indexes, and score
  validation.
- Implement Eloquent relationships, helpers, scopes, and `NimParser`.
- Write and pass NIM parser tests.
- Write and pass seed completeness tests.
- Implement factories and seeders with realistic Universitas Mulia data.
- Write and pass `EvaluationResultService` tests.
- Implement centralized zero-safe Likert result calculations.

### Track 4: Admin And Mahasiswa Workflows

Issues: `#19` through `#25`

- Write and pass admin CRUD and cross-role tests.
- Implement admin dashboard, student management, and period management.
- Implement form, category, and question management.
- Write and pass profile completion tests.
- Implement student profile completion with parsed NIM fields.
- Write and pass evaluation submission tests.
- Implement student dashboard, active form list, fill/submit/success flow, and
  submission history.

### Track 5: Results, Charts, And Exports

Issues: `#26` through `#33`

- Write and pass result dashboard filter and empty-state tests.
- Implement result index/detail pages backed by `EvaluationResultService`.
- Write and pass chart data wiring tests.
- Implement ApexCharts charts from real result data.
- Write and pass protected PDF export tests.
- Implement PDF report export.
- Write and pass protected Excel export tests.
- Implement multi-sheet Excel report export.

### Track 6: UI Wiring, Regression, Documentation, And E2E Proof

Issues: `#34` through `#41`

- Complete responsive Indonesian Blade/Tailwind UI states.
- Write and pass route/controller/view wiring tests.
- Complete the required Pest regression suite.
- Run Pint, Pest, build, and route-list quality gates.
- Replace default README with SurveyKita setup, demo accounts, and verification
  instructions.
- Run final quickstart verification.
- Run seeded browser E2E verification with `agent-browser`.
- Document unattended autonomous execution protocol.

## GitHub Issues Tracking Rules

- The GitHub remote must remain `https://github.com/yehezkieldio/surveykita.git`.
  Do not create, update, or close issues in any other repository.
- Treat issues `#1` through `#41` as the canonical implementation queue for
  `T001` through `T041`.
- Before starting a task or slice, read the corresponding issue body and the
  matching entry in `tasks.md`.
- Keep `.spec/goal/implementation-report.md` updated with:
  - current issue number and task ID;
  - current status;
  - files changed;
  - verification run;
  - commit hash;
  - issue closure or remaining work.
- Close a GitHub Issue only after its acceptance criteria and verification
  command or equivalent Pest test are satisfied.
- Prefer closing issues through commit messages when the slice fully completes
  the issue. Use explicit GitHub closing keywords only when closure is earned:
  `Closes #N`, `Fixes #N`, or `Resolves #N`.
- If a commit only contributes to an issue, reference it without closing:
  `Refs #N`.
- If one coherent slice completes multiple issues, the commit may close multiple
  issues, but the report must explain why the slice is coherent.
- If an issue cannot be closed because of an external blocker, leave it open,
  add a clear report entry, and continue with independent unblocked work if
  possible.

## Conventional Commit Rules

Commit every completed slice of work or task. Do not accumulate the entire
multi-hour implementation into one large final commit.

Use Conventional Commit messages and reference the relevant GitHub Issue
number(s):

```text
feat(auth): implement custom session login

Closes #7
```

```text
test(student): cover NIM parsing rules

Refs #14
```

Allowed types:

- `feat`: user-facing or admin-facing functionality
- `fix`: correction to broken behavior
- `test`: automated tests
- `docs`: README or documentation
- `chore`: setup, tooling, dependencies, config, quality gates
- `refactor`: internal restructuring without behavior change
- `style`: Blade/Tailwind UI-only changes
- `perf`: performance improvement
- `ci`: CI or automation changes

Commit rules:

- Run the focused verification for the slice before committing.
- Run `vendor/bin/pint --dirty --format agent` before committing PHP changes.
- Commit only intentional changes for the current slice. Do not revert unrelated
  user or agent changes.
- Do not commit secrets, `.env`, generated browser screenshots containing
  secrets, or local-only caches.
- Use closing keywords only when the issue is actually complete.
- After each commit, record the commit hash and issue mapping in
  `.spec/goal/implementation-report.md`.

## Patch-And-Continue Rule

If something fails:

1. Stop the current implementation or verification step.
2. Classify the failure:
   - implementation bug;
   - test bug;
   - spec or task mismatch;
   - dependency or package conflict;
   - local environment or Docker/MariaDB issue;
   - browser automation issue;
   - external OAuth/provider issue;
   - operator decision required.
3. Patch the smallest responsible code, test, config, or documentation surface.
4. Add or update tests when the fix changes behavior.
5. Run the smallest focused failing gate first.
6. Run the broader related gate after the focused gate passes.
7. Commit the fix as a coherent Conventional Commit slice that references or
   closes the relevant issue number(s).
8. Record the failure, classification, fix, verification, and commit hash in
   `.spec/goal/implementation-report.md`.
9. Continue with the dependency-ordered task queue.

Do not skip ahead and call a failed task complete without rerunning the failed
verification. Do not hide manual database edits, manual browser actions, or
local hacks as product behavior.

## Required Verification Gates

Run focused gates during implementation and final gates before completion.

### Focused Gates

Use the verification command from each issue or task, including but not limited
to:

- `composer validate`
- `composer show laravel/socialite akaunting/laravel-apexcharts barryvdh/laravel-dompdf maatwebsite/excel pestphp/pest pestphp/pest-plugin-laravel`
- `docker compose config`
- `php artisan config:show database.default`
- `bun install --frozen-lockfile`
- `bun run build`
- `php artisan route:list --except-vendor`
- `php artisan test --compact --filter=SessionAuthTest`
- `php artisan test --compact --filter=RoleAccessTest`
- `php artisan test --compact --filter=GoogleOAuthTest`
- `php artisan test --compact --filter=NimParserTest`
- `php artisan test --compact --filter=SeedDataTest`
- `php artisan test --compact --filter=EvaluationResultServiceTest`
- `php artisan test --compact --filter=AdminCrudTest`
- `php artisan test --compact --filter=ProfileCompletionTest`
- `php artisan test --compact --filter=EvaluationSubmissionTest`
- `php artisan test --compact --filter=ResultDashboardTest`
- `php artisan test --compact --filter=ResultChartsTest`
- `php artisan test --compact --filter=PdfExportTest`
- `php artisan test --compact --filter=ExcelExportTest`
- `php artisan test --compact --filter=UiRouteWiringTest`

### Final Local Gates

Before declaring completion, run and record:

```bash
docker compose up -d
php artisan migrate:fresh --seed
vendor/bin/pint --dirty --format agent
php artisan test --compact
bun run build
php artisan route:list --except-vendor
```

Also verify:

- every route-contract route exists and maps to a real controller action;
- every controller action returns a real response or Blade view;
- every visible button/link points to an existing named route or intended
  external behavior;
- no banned dependencies or starter kits are present;
- no `TODO` comments remain for core behavior;
- no placeholder pages, fake UI, empty tests, or dead routes remain;
- seeded data makes dashboards and reports immediately demonstrable.

### Browser E2E Gate

After final local gates pass:

```bash
agent-browser skills get core
php artisan serve --host=127.0.0.1 --port=8000
agent-browser open http://127.0.0.1:8000/login
agent-browser snapshot -i
```

Verify seeded admin and mahasiswa workflows from `quickstart.md`:

- admin login, dashboard, CRUD navigation, result dashboard, charts, PDF export,
  Excel export, and logout;
- mahasiswa login, profile completion when needed, active form list, form
  detail, evaluation submission, success page, duplicate submission feedback,
  and submission history;
- wrong-role access blocks safely;
- at least one empty result state renders without errors.

Capture snapshots or screenshots as evidence. Close task-owned browser sessions:

```bash
agent-browser close --all
pgrep -af "agent-browser|chrome|chromium" || true
```

Record all browser evidence and cleanup results in the implementation report.

## Stop Conditions

Stop and report instead of continuing if:

- The Git remote is not `https://github.com/yehezkieldio/surveykita.git` and
  issue writes or closures would target the wrong repository.
- GitHub authentication or issue-writing capability disappears and issue
  tracking cannot be performed safely.
- A required action would print, commit, or expose `.env` secrets, Google OAuth
  secrets, database passwords, or tokens.
- A required action would delete or overwrite non-disposable data outside this
  local development database.
- A required action would use or install a constitution-banned package or
  starter kit.
- A dependency conflict cannot be solved with the approved fallback rules.
- Docker or MariaDB cannot be made available after focused diagnosis and the
  database-backed verification gates cannot run.
- The implementation requires a product decision not already covered by the
  constitution, spec, clarifications, plan, tasks, or this goal.
- Browser automation cannot proceed because the app cannot be served locally
  after final gates have passed and targeted fixes have been attempted.
- The only remaining blocker is live Google account MFA/CAPTCHA/consent. In
  that case do not stop the whole implementation; record it as an external
  limitation and rely on Socialite fake tests plus seeded password-account E2E.

Do not stop merely because the work is large, tests initially fail, packages
need approved installation, migrations need resetting, or focused fixes are
required. Patch and continue.

## Evidence And Reporting Requirements

Create and maintain:

```text
.spec/goal/implementation-report.md
```

Update it during the run, especially after each implemented slice, failed gate,
fix, commit, and issue closure.

The report must include:

- date/time and timezone;
- active branch and commit hash at start;
- GitHub repository and issue list summary;
- current phase/track;
- status table for issues `#1` through `#41`;
- task IDs mapped to issue numbers and commit hashes;
- files changed per slice;
- decisions made autonomously and why;
- dependency/package decisions, including any approved chart fallback;
- migrations and schema evidence;
- NIM parser evidence;
- auth and role boundary evidence;
- Google OAuth fake-test evidence and any live-browser limitation;
- seed data evidence;
- calculation service evidence;
- admin CRUD evidence;
- student profile/submission evidence;
- result dashboard and chart evidence;
- PDF and Excel export evidence;
- UI route wiring evidence;
- every verification command run, with pass/fail result;
- every failed step, classification, fix, and reproof result;
- every commit message and commit hash;
- every GitHub Issue closed or intentionally left open;
- browser snapshots/screenshots paths or descriptions;
- local server, Docker, and browser cleanup evidence;
- final dirty/clean working tree state;
- final completion judgment.

Use redaction for secrets and credentials. Do not paste secret values into the
report.

## Final Completion Decision

SurveyKita is complete only if all of these are true:

- Issues `#1` through `#41` are complete and closed, or any exception is
  explicitly justified with an equivalent completed replacement and evidence.
- All Spec Kit acceptance criteria are implemented without MVP or placeholder
  language.
- The constitution gates are satisfied.
- Custom auth, role boundaries, Google OAuth restrictions, profile completion,
  NIM parsing, evaluation submission rules, result calculation, charts, PDF
  export, Excel export, seed data, README, and browser E2E are all verified.
- Final local gates pass.
- Browser E2E gate passes for seeded local workflows, with any live Google OAuth
  limitation clearly recorded.
- `.spec/goal/implementation-report.md` is complete and auditable.
- All implementation slices are committed with Conventional Commit messages
  referencing or closing the relevant GitHub Issue number(s).
- The worktree is clean, or every remaining dirty file is explicitly listed and
  justified in the report.

If any item fails, SurveyKita is not complete. Write the exact blocker, leave
the relevant GitHub Issue open, and record the next required action in
`.spec/goal/implementation-report.md`.
