# Feature Specification: SurveyKita Academic Evaluation System

**Feature Branch**: `001-surveykita-evaluations`

**Created**: 2026-05-31

**Status**: Draft

**Input**: User description: "Build a complete web-based information system titled SurveyKita for Universitas Mulia student satisfaction evaluations toward academic services, including authentication, role-based access, Google student login, admin evaluation management, mahasiswa submission flow, result calculation, dashboards, charts, PDF and Excel exports, seed data, and automated tests."

## Constitution Alignment *(mandatory)*

- **Whole-app scope**: This feature defines the complete SurveyKita application:
  authentication, admin dashboard, mahasiswa dashboard, student management,
  evaluation period management, evaluation form management, question category
  management, question management, active evaluation submission, result
  dashboards, charts, exports, seed data, and automated verification. Every
  listed page and action is in scope and must be connected to real user-visible
  behavior.
- **Stack compliance**: The feature follows the ratified SurveyKita
  constitution: Laravel 13, Blade, Tailwind, Bun, Vite, MariaDB, Pest, Google
  OAuth through the approved student-domain rule, chart rendering, PDF export,
  and Excel export. No banned starter kits, admin panel generators, frontend
  frameworks, alternate JavaScript package managers, Bootstrap, or SQLite main
  local database are permitted.
- **Role boundaries**: Admin owns master data, results, dashboards, reports, and
  exports. Mahasiswa owns profile completion, viewing active forms, submitting
  evaluations, and reviewing submission status. Public unauthenticated access is
  limited to login, login submission, Google login start, Google callback
  feedback, and safe error states.
- **Domain rules**: SurveyKita evaluates Universitas Mulia academic services
  through evaluation periods, forms, categories, questions, responses, and
  response answers. A student may submit one response per form, only for active
  forms inside active date-valid periods, and only after completing required
  profile data. Scores are valid only from 1 to 5.
- **No placeholders**: The complete specification requires real pages, real
  actions, working navigation, empty states, seed data, result calculations,
  exports, and behavior-focused tests. Fake links, placeholder pages, dead
  routes, unwired modules, and empty tests are out of scope and must be treated
  as defects.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Admin Manages Evaluation Program (Priority: P1)

An academic administrator logs in, opens the admin dashboard, and manages all
master data needed to run student satisfaction evaluations for Universitas
Mulia. The admin can manage mahasiswa records, evaluation periods, evaluation
forms, question categories, and questions, including activating or deactivating
periods and forms.

**Why this priority**: Without complete admin management, no valid evaluation
forms, questions, periods, or student accounts exist for the academic evaluation
process.

**Independent Test**: Use seeded admin credentials to sign in, open the admin
dashboard, create and edit a student, create and edit an evaluation period,
create and edit an evaluation form, create and edit a category, create and edit
a question, deactivate and reactivate a period or form, view detail pages where
required, delete removable records, and confirm mahasiswa users cannot access
these admin areas.

**Acceptance Scenarios**:

1. **Given** an admin is authenticated, **When** the admin opens each master data
   list, **Then** the system shows real records, create/edit/detail/delete
   actions where required, and clear feedback after changes.
2. **Given** a mahasiswa is authenticated, **When** the mahasiswa attempts to
   open any admin management page, **Then** the system blocks access safely and
   shows unauthorized feedback.
3. **Given** an evaluation period or form is deactivated by admin, **When**
   mahasiswa users view available evaluations, **Then** inactive items are not
   available for submission.

---

### User Story 2 - Mahasiswa Completes and Submits Evaluation (Priority: P1)

A mahasiswa logs in with email/password or an allowed Universitas Mulia student
Google account, completes missing student profile data when required, views
active evaluation forms, fills a form using the 1-5 Likert scale, optionally
adds suggestions or comments, submits the evaluation, and sees the submitted
status afterward.

**Why this priority**: Student submission is the central academic evaluation
workflow and the source of all report data.

**Independent Test**: Sign in as a seeded mahasiswa and submit an active form
with all required scores. Attempt duplicate submission, inactive form
submission, expired period submission, invalid score submission, and submission
with incomplete profile data. Simulate allowed and rejected Google account
domains and confirm only eligible student accounts can proceed.

**Acceptance Scenarios**:

1. **Given** a mahasiswa has complete profile data and an active form is inside
   an active period date range, **When** the mahasiswa answers required
   questions with scores from 1 to 5 and submits, **Then** the response is saved
   and the success page confirms submission.
2. **Given** a mahasiswa already submitted a form, **When** the mahasiswa opens
   the active forms list or submission history, **Then** the form is marked as
   already submitted and cannot be submitted again.
3. **Given** a mahasiswa profile is incomplete, **When** the mahasiswa attempts
   to submit any evaluation, **Then** the system redirects the mahasiswa to
   profile completion before allowing submission.
4. **Given** a Google account email does not end with
   `@students.universitasmulia.ac.id`, **When** login returns from Google,
   **Then** the system rejects the account and does not create an admin or
   mahasiswa account.

---

### User Story 3 - Admin Reviews Results, Charts, and Reports (Priority: P1)

An admin opens the result dashboard to review satisfaction summaries for
completed evaluations. The admin filters results by period, form, and category,
reviews summary cards, inspects charts, reads student suggestions or comments,
opens result detail per form, and exports reports to PDF and Excel.

**Why this priority**: The system exists to turn mahasiswa responses into
academic service evaluation results that can be reviewed, reported, and shared.

**Independent Test**: Seed completed responses, log in as admin, open result
dashboard, filter by period/form/category, verify total respondents, average
score, satisfaction percentage, category label, chart data, and suggestions.
Export PDF and Excel reports, then confirm mahasiswa and unauthenticated users
cannot access result or export pages.

**Acceptance Scenarios**:

1. **Given** seeded responses exist, **When** the admin opens the result
   dashboard, **Then** the system shows total respondents, average score,
   satisfaction percentage, satisfaction category, result tables, charts, and
   suggestions based on real response data.
2. **Given** no responses exist for a selected filter, **When** the admin views
   results, **Then** the system shows zero-safe summaries and empty states
   instead of errors.
3. **Given** an admin filters by period, form, or category, **When** the filter
   is applied, **Then** all summary cards, charts, tables, suggestions, and
   exports reflect the selected filter.
4. **Given** an admin requests PDF or Excel export, **When** the report is
   generated, **Then** the exported file contains the required summary,
   category, question, and suggestion or raw response information.

---

### User Story 4 - Seeded Local Demonstration (Priority: P2)

A developer, lecturer, or evaluator can set up the project locally, migrate and
seed the database, sign in with demo accounts, and immediately demonstrate the
admin and mahasiswa workflows with meaningful seeded results.

**Why this priority**: SurveyKita is a university framework programming group
project and must be locally demonstrable without manual data preparation.

**Independent Test**: Start from a fresh local setup, run documented setup,
migration, seeding, asset, and test commands, then log in with demo admin and
mahasiswa accounts and verify dashboards, forms, charts, and reports contain
real seeded data.

**Acceptance Scenarios**:

1. **Given** a fresh local setup, **When** the documented migration and seed flow
   completes, **Then** the system contains one admin account, several mahasiswa
   accounts, student profiles, two evaluation periods, forms, categories,
   15-25 realistic questions, and several completed responses.
2. **Given** seeded data exists, **When** an evaluator logs in as admin,
   **Then** dashboard charts and report exports are meaningful immediately.
3. **Given** seeded mahasiswa accounts exist, **When** an evaluator logs in as a
   mahasiswa, **Then** the system clearly shows available forms and prior
   submission status.

### Edge Cases

- Mahasiswa attempts to submit the same evaluation form twice.
- Mahasiswa attempts to submit an inactive evaluation form.
- Mahasiswa attempts to submit a form attached to an inactive period.
- Mahasiswa attempts to submit a form outside the period start/end date range.
- Mahasiswa submits without answering every required question.
- Mahasiswa submits a score below 1, above 5, missing, non-numeric, or otherwise
  invalid.
- Mahasiswa with incomplete profile data attempts to submit an evaluation.
- Google login returns an email outside `@students.universitasmulia.ac.id`.
- Google login returns an allowed student email for a new user with incomplete
  profile data.
- Google login returns an allowed student email that already belongs to an
  existing mahasiswa user.
- A Google login attempt must never create or upgrade an admin account.
- Admin attempts to submit an evaluation intended for mahasiswa.
- Mahasiswa attempts to open admin result, export, or master data pages.
- Unauthenticated user attempts to access protected admin or mahasiswa pages.
- Result filters select a period, form, or category with no responses.
- A report export is requested for a result set with no responses.
- Student suggestions/comments are empty for some or all responses.

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST provide a login page, email/password login
  submission, Google student login entry point, logout action, unauthorized
  feedback, and non-student Google email rejection feedback.
- **FR-002**: System MUST route authenticated users to the correct dashboard
  based on role: admin to admin dashboard and mahasiswa to mahasiswa dashboard.
- **FR-003**: System MUST disable public registration unless a future approved
  feature implements safe student-domain restrictions.
- **FR-004**: System MUST allow admin users to create, list, view, edit, and
  delete student records where deletion does not violate existing evaluation
  records.
- **FR-005**: System MUST allow admin users to create, list, view, edit, delete,
  activate, and deactivate evaluation periods.
- **FR-006**: System MUST allow admin users to create, list, view, edit, delete,
  activate, and deactivate evaluation forms attached to evaluation periods.
- **FR-007**: System MUST allow admin users to create, list, edit, and delete
  question categories used to group academic service questions.
- **FR-008**: System MUST allow admin users to create, list, edit, and delete
  evaluation questions attached to forms and categories.
- **FR-009**: System MUST support evaluation areas including academic services,
  learning, facilities, administration, and overall satisfaction.
- **FR-010**: System MUST allow mahasiswa users to view only evaluation forms
  that are available to them, with already-submitted forms clearly marked.
- **FR-011**: System MUST allow mahasiswa users to open an evaluation form detail
  page before filling it.
- **FR-012**: System MUST allow mahasiswa users to fill each required question
  with exactly one score from 1 to 5 using the defined Likert labels.
- **FR-013**: System MUST allow mahasiswa users to submit optional suggestions
  or comments with an evaluation response.
- **FR-014**: System MUST show a submission success page after a valid
  mahasiswa response is saved.
- **FR-015**: System MUST provide mahasiswa users with a submission
  status/history page that shows submitted and unsubmitted forms.
- **FR-016**: System MUST prevent a mahasiswa from submitting more than one
  response for the same evaluation form.
- **FR-017**: System MUST prevent submission for inactive evaluation forms.
- **FR-018**: System MUST prevent submission for forms attached to inactive
  evaluation periods.
- **FR-019**: System MUST prevent submission outside the evaluation period date
  range.
- **FR-020**: System MUST prevent submission while required student profile data
  is incomplete and MUST direct the mahasiswa to profile completion.
- **FR-021**: System MUST allow mahasiswa users to complete required student
  profile data before submitting evaluations.
- **FR-022**: System MUST allow Google login only for lowercase-normalized emails
  ending with `@students.universitasmulia.ac.id`.
- **FR-023**: System MUST create or link only mahasiswa accounts through Google
  login and MUST never create admin accounts through Google login.
- **FR-024**: System MUST allow admin-created mahasiswa accounts to log in using
  email and password.
- **FR-025**: System MUST restrict student, period, form, category, question,
  result, and export management to admin users.
- **FR-026**: System MUST restrict evaluation submission pages and actions to
  mahasiswa users.
- **FR-027**: System MUST provide an admin result dashboard with filters for
  period, form, and category.
- **FR-028**: System MUST show result summary cards for total respondents,
  average score, satisfaction percentage, and satisfaction category.
- **FR-029**: System MUST calculate average score as total score divided by total
  answers.
- **FR-030**: System MUST calculate satisfaction percentage as average score
  divided by 5 and multiplied by 100.
- **FR-031**: System MUST map satisfaction percentage to categories: 0-20
  Sangat Tidak Puas, 21-40 Tidak Puas, 41-60 Cukup Puas, 61-80 Puas, and
  81-100 Sangat Puas.
- **FR-032**: System MUST show zero-safe summaries and empty states when no
  responses exist for the selected result set.
- **FR-033**: System MUST show result tables or summaries per category and per
  question.
- **FR-034**: System MUST show student suggestions/comments to admin users in
  result views.
- **FR-035**: System MUST provide charts for overall satisfaction percentage per
  form, average score per category, respondent count per form, and Likert score
  distribution from 1 to 5.
- **FR-036**: System MUST provide admin-only PDF export containing evaluation
  title, period, total respondents, average score, satisfaction percentage,
  satisfaction category, result per category, result per question, and
  suggestions/comments.
- **FR-037**: System MUST provide admin-only Excel export containing a summary
  sheet, category recap sheet, question recap sheet, and raw responses sheet
  when response data exists.
- **FR-038**: System MUST seed one admin account, several mahasiswa accounts,
  several student profiles, two evaluation periods, several evaluation forms,
  several question categories, 15-25 realistic questions, and several completed
  responses.
- **FR-039**: System MUST provide clear validation and feedback for invalid
  login, unauthorized access, rejected Google email, invalid submission, and
  blocked duplicate submission.
- **FR-040**: System MUST ensure every visible navigation item, button, form, and
  action listed in this specification leads to working behavior or a clear safe
  feedback state.
- **FR-041**: System MUST include automated behavior tests covering role access,
  login, logout, Google student-domain filtering, profile completion,
  management workflows, submission rules, calculation correctness, result
  categories, protected PDF export, and protected Excel export.

### Key Entities *(include if feature involves data)*

- **User**: Authentication identity for admin or mahasiswa. Key information
  includes name, unique email, password status when applicable, role, and Google
  identity linkage when applicable.
- **Student**: Mahasiswa profile linked to one user. Key information includes
  unique NIM, academic identity details, program/department context, and required
  profile completion status.
- **Evaluation Period**: Academic evaluation time window. Key information
  includes title, description, start date, end date, active status, and related
  forms.
- **Evaluation Form**: Evaluation instrument attached to one period. Key
  information includes title, description, target area, active status, related
  questions, and collected responses.
- **Question Category**: Academic service grouping such as `layanan_akademik`,
  `pembelajaran`, `fasilitas`, `administrasi`, or `kepuasan_umum`.
- **Question**: Prompt answered by mahasiswa using a 1-5 Likert score. Each
  question belongs to one form and one category and may be required.
- **Response**: One mahasiswa submission for one evaluation form. Each response
  belongs to one student and one form and may include optional suggestions or
  comments.
- **Response Answer**: One answer inside a response for one question. Each
  answer stores a valid score from 1 to 5.

### Required Relationships

- A user may have one student profile.
- A student belongs to a user.
- An evaluation period has many evaluation forms.
- An evaluation form belongs to an evaluation period.
- An evaluation form has many questions.
- A question belongs to one evaluation form.
- A question belongs to one question category.
- A question category has many questions.
- A student has many responses.
- An evaluation form has many responses.
- A response belongs to one student and one evaluation form.
- A response has many response answers.
- A response answer belongs to one response and one question.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: A fresh local setup can be migrated and seeded, then demonstrate
  both admin and mahasiswa workflows using documented demo accounts in under 30
  minutes.
- **SC-002**: 100% of required admin pages and mahasiswa pages listed in this
  specification are reachable by the correct role and blocked from the wrong
  role.
- **SC-003**: A mahasiswa with complete profile data can submit an active
  evaluation with required Likert answers and optional comments in under 5
  minutes.
- **SC-004**: Duplicate, inactive form, inactive period, expired period, invalid
  score, and incomplete profile submission attempts are blocked with clear user
  feedback.
- **SC-005**: Result summaries show mathematically correct total respondents,
  average score, satisfaction percentage, category labels, per-category values,
  per-question values, and Likert distribution for seeded and newly submitted
  data.
- **SC-006**: Result pages show empty states and zero-safe summaries without
  errors when selected filters have no responses.
- **SC-007**: PDF and Excel reports generated by admin users contain the
  required summary, category, question, and suggestion or raw response sections.
- **SC-008**: Allowed Universitas Mulia student Google accounts can enter the
  mahasiswa flow, while non-student Google emails are rejected and never create
  admin accounts.
- **SC-009**: Automated tests cover the core acceptance criteria and pass before
  the feature is considered complete.
- **SC-010**: The completed application contains no fake links, placeholder
  pages, dead routes, unwired modules, or empty tests for the specified scope.

## Assumptions

- Universitas Mulia student Google accounts use NIM-style local parts, for
  example `2311032@students.universitasmulia.ac.id`, and the local part can be
  used as a default NIM candidate until confirmed or completed in the student
  profile.
- Required student profile data includes at least NIM, full name, study program
  or academic department, and cohort or class information sufficient for
  academic reporting.
- Admin accounts are seeded or manually created by existing administrators;
  public self-registration remains disabled.
- Deleting master data that already has dependent responses is either blocked
  with clear feedback or handled through safe deactivation, preserving academic
  evaluation records.
- Suggestions/comments are stored at response level and may be empty.
- Result filters can be combined by period, form, and category; when a filter is
  omitted, the dashboard summarizes all applicable data for the admin.
- The raw responses sheet in Excel export is included when practical and when it
  does not expose data beyond the admin reporting purpose.
- SurveyKita remains a Laravel 13 Blade/Tailwind application.
- Bun remains the only JavaScript package manager.
- MariaDB through Docker Compose remains the local development database.
- Google OAuth is student-only and restricted to
  `@students.universitasmulia.ac.id`.
- Admin accounts are manually provisioned or seeded, not created by Google OAuth.
