# Feature Specification: [FEATURE NAME]

**Feature Branch**: `[###-feature-name]`

**Created**: [DATE]

**Status**: Draft

**Input**: User description: "$ARGUMENTS"

## Constitution Alignment *(mandatory)*

<!--
  Every generated feature MUST comply with the SurveyKita Constitution.
  Do not weaken whole-app delivery into an MVP, starter-kit demo, admin-panel
  shortcut, generic CRUD-only module, or unwired scaffold.
-->

- **Whole-app scope**: [Explain how this feature connects to real SurveyKita
  workflows, routes, controllers, Blade views, buttons, authorization, tests,
  seed data, and local demonstration.]
- **Stack compliance**: [Confirm Laravel 13, Blade, Tailwind, Bun, Vite,
  MariaDB, Pest, and allowed packages. List any dependency needing approval.]
- **Role boundaries**: [Identify admin-only, mahasiswa-only, and shared access.]
- **Domain rules**: [Identify relevant academic evaluation rules and database
  invariants.]
- **No placeholders**: [State how fake UI, TODO-only behavior, orphan routes,
  and empty tests will be avoided.]

## User Scenarios & Testing *(mandatory)*

<!--
  User stories MUST describe complete, demonstrable SurveyKita workflows.
  They may be prioritized for planning order, but generated work must preserve
  complete whole-app delivery rather than stopping at a narrow MVP.
-->

### User Story 1 - [Brief Title] (Priority: P1)

[Describe this SurveyKita user journey in plain language.]

**Why this priority**: [Explain the academic or administrative value.]

**Independent Test**: [Describe the Pest or manual flow that proves this story
works with real routes, controllers, views, validation, authorization, and data.]

**Acceptance Scenarios**:

1. **Given** [initial state], **When** [action], **Then** [expected outcome]
2. **Given** [initial state], **When** [action], **Then** [expected outcome]

---

### User Story 2 - [Brief Title] (Priority: P2)

[Describe this SurveyKita user journey in plain language.]

**Why this priority**: [Explain the academic or administrative value.]

**Independent Test**: [Describe how this can be tested independently.]

**Acceptance Scenarios**:

1. **Given** [initial state], **When** [action], **Then** [expected outcome]

---

### User Story 3 - [Brief Title] (Priority: P3)

[Describe this SurveyKita user journey in plain language.]

**Why this priority**: [Explain the academic or administrative value.]

**Independent Test**: [Describe how this can be tested independently.]

**Acceptance Scenarios**:

1. **Given** [initial state], **When** [action], **Then** [expected outcome]

---

[Add more user stories as needed, each with an assigned priority.]

### Edge Cases

- What happens when a mahasiswa tries to submit the same evaluation form twice?
- What happens when a form is inactive?
- What happens when an evaluation period is inactive or expired?
- What happens when required questions are missing answers?
- What happens when scores are outside 1-5?
- What happens when a mahasiswa profile is incomplete?
- What happens when a Google OAuth email is outside the allowed student domain?
- What happens when admin and mahasiswa attempt cross-role access?

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST [specific SurveyKita capability].
- **FR-002**: System MUST validate input through Form Request classes where
  request validation is needed.
- **FR-003**: System MUST protect routes with auth and role middleware.
- **FR-004**: System MUST return real Blade views or redirects for every planned
  controller action.
- **FR-005**: System MUST persist data through migrations, models, relationships,
  validation, and database constraints.
- **FR-006**: System MUST include Pest coverage for real behavior affected by
  this feature.
- **FR-007**: System MUST avoid fake buttons, placeholder dashboards, dead
  routes, orphan controllers, and TODO-only core behavior.

### Key Entities *(include if feature involves data)*

- **User**: Authentication identity with unique email and role.
- **Student**: Mahasiswa profile linked one-to-one with a user and uniquely
  identified by NIM.
- **EvaluationPeriod**: Time window that controls whether forms can be submitted.
- **EvaluationForm**: Admin-managed form that students answer during an active
  period.
- **QuestionCategory**: Grouping for academic service evaluation questions.
- **Question**: Required or optional Likert question within a form/category.
- **Response**: One student submission for one evaluation form.
- **ResponseAnswer**: Score and optional answer data for one question.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: [Users can complete the intended workflow locally using seeded or
  documented data.]
- **SC-002**: [Relevant Pest tests pass and cover the behavior, not only status
  codes.]
- **SC-003**: [Admin and mahasiswa role boundaries are enforced for the feature.]
- **SC-004**: [The feature can be explained using SurveyKita domain entities and
  does not depend on banned starter kits or admin generators.]

## Assumptions

- SurveyKita remains a Laravel 13 Blade/Tailwind application.
- Bun remains the only JavaScript package manager.
- MariaDB through Docker Compose remains the local development database.
- Google OAuth is student-only and restricted to
  `@students.universitasmulia.ac.id`.
- Admin accounts are manually provisioned or seeded, not created by Google OAuth.
