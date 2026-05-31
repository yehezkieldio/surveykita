# Data Model: SurveyKita Academic Evaluation System

## Entity: User

**Table**: `users`

**Fields**:

- `id` big integer primary key
- `name` string, required
- `email` string, required, lowercase, unique
- `password` string nullable
- `role` string or enum-like value, required: `admin` or `mahasiswa`
- `google_id` string nullable, indexed
- `email_verified_at` timestamp nullable
- `remember_token` string nullable
- `created_at`, `updated_at` timestamps

**Relationships**:

- Has one `Student`

**Helpers**:

- `student()`
- `isAdmin(): bool`
- `isMahasiswa(): bool`
- `hasCompleteStudentProfile(): bool`

**Validation and integrity**:

- `email` unique
- `role` restricted to `admin` or `mahasiswa`
- `password` required for password-created users
- `password` nullable for Google-only users
- `google_id` nullable index
- Google OAuth can create/link only `mahasiswa`

## Entity: Student

**Table**: `students`

**Fields**:

- `id` big integer primary key
- `user_id` foreign key to `users.id`, unique
- `nim` string nullable until profile completion, unique when not null
- `name` string, required
- `study_program` string nullable until profile completion
- `class_name` string nullable until profile completion
- `created_at`, `updated_at` timestamps

**Relationships**:

- Belongs to `User`
- Has many `Response`

**Profile completion rule**:

Complete when `nim`, `name`, `study_program`, and `class_name` are all present.

**Validation and integrity**:

- `user_id` unique and foreign-key constrained
- `nim` unique when not null
- Student profile must belong to a `mahasiswa` user

## Entity: EvaluationPeriod

**Table**: `evaluation_periods`

**Fields**:

- `id` big integer primary key
- `name` string, required
- `semester` string, required
- `academic_year` string, required
- `start_date` date, required
- `end_date` date, required
- `is_active` boolean, required, default false
- `created_at`, `updated_at` timestamps

**Relationships**:

- Has many `EvaluationForm`

**Helpers**:

- `evaluationForms()`
- `scopeActive($query)`
- `isCurrentlyOpen(): bool`

**Validation and integrity**:

- `end_date` must be on or after `start_date`
- Index `is_active`, `start_date`, `end_date`, and `academic_year`

**State transitions**:

- Draft/inactive -> active
- Active -> inactive
- Expired by date when today is after `end_date`

## Entity: EvaluationForm

**Table**: `evaluation_forms`

**Fields**:

- `id` big integer primary key
- `evaluation_period_id` foreign key to `evaluation_periods.id`
- `title` string, required
- `description` text nullable
- `target_type` string, required. Values include `layanan_akademik`,
  `pembelajaran`, `fasilitas`, `administrasi`, `kepuasan_umum`
- `is_active` boolean, required, default false
- `created_at`, `updated_at` timestamps

**Relationships**:

- Belongs to `EvaluationPeriod`
- Has many `Question`
- Has many `Response`

**Helpers**:

- `evaluationPeriod()`
- `questions()`
- `responses()`
- `isFillable(?Student $student = null): bool`

**Validation and integrity**:

- Foreign key to period
- Index `evaluation_period_id`, `target_type`, and `is_active`
- Fillable only when form active, period active, today is between period
  `start_date` and `end_date` inclusive, and the student has not responded

## Entity: QuestionCategory

**Table**: `question_categories`

**Fields**:

- `id` big integer primary key
- `name` string, required, unique
- `description` text nullable
- `created_at`, `updated_at` timestamps

**Relationships**:

- Has many `Question`

**Validation and integrity**:

- `name` unique
- Seed categories include academic services, learning, facilities,
  administration, and general satisfaction

## Entity: Question

**Table**: `questions`

**Fields**:

- `id` big integer primary key
- `evaluation_form_id` foreign key to `evaluation_forms.id`
- `question_category_id` foreign key to `question_categories.id`
- `question_text` text, required
- `sort_order` unsigned integer, required, default 0
- `is_required` boolean, required, default true
- `created_at`, `updated_at` timestamps

**Relationships**:

- Belongs to `EvaluationForm`
- Belongs to `QuestionCategory`
- Has many `ResponseAnswer`

**Validation and integrity**:

- Foreign keys to form and category
- Index `evaluation_form_id`, `question_category_id`, and `sort_order`
- Required questions must receive valid scores during submission

## Entity: Response

**Table**: `responses`

**Fields**:

- `id` big integer primary key
- `evaluation_form_id` foreign key to `evaluation_forms.id`
- `student_id` foreign key to `students.id`
- `submitted_at` timestamp, required
- `suggestion` text nullable
- `created_at`, `updated_at` timestamps

**Relationships**:

- Belongs to `EvaluationForm`
- Belongs to `Student`
- Has many `ResponseAnswer`

**Validation and integrity**:

- Composite unique key on `evaluation_form_id` and `student_id`
- Index `evaluation_form_id`, `student_id`, and `submitted_at`
- Response creation must happen inside a transaction with answers

## Entity: ResponseAnswer

**Table**: `response_answers`

**Fields**:

- `id` big integer primary key
- `response_id` foreign key to `responses.id`
- `question_id` foreign key to `questions.id`
- `score` unsigned tiny integer, required
- `created_at`, `updated_at` timestamps

**Relationships**:

- Belongs to `Response`
- Belongs to `Question`

**Validation and integrity**:

- Composite unique key on `response_id` and `question_id`
- `score` validated at application level as integer 1-5
- `score` constrained at database level where MariaDB supports check constraints
- Index `question_id` and `score`

## Derived Result Shape

`EvaluationResultService` returns:

- `filters`: selected period/form/category
- `total_respondents`: integer
- `total_answers`: integer
- `average_score`: decimal, 2 precision
- `satisfaction_percentage`: decimal, 2 precision
- `satisfaction_category`: one of `Belum Ada Data`, `Sangat Tidak Puas`,
  `Tidak Puas`, `Cukup Puas`, `Puas`, `Sangat Puas`
- `category_averages`: category label, total answers, average score, percentage
- `question_averages`: question text, category, total answers, average score,
  percentage
- `likert_distribution`: counts for scores 1, 2, 3, 4, 5
- `suggestions`: submitted timestamp, form title, student identifier, suggestion

## Empty Result State

When no answers exist for the selected filters:

- total respondents: `0`
- total answers: `0`
- average score: `0.00`
- satisfaction percentage: `0.00`
- satisfaction category: `Belum Ada Data`
- category and question collections: empty
- Likert distribution: 1-5 all zero
- suggestions: empty
- charts and exports receive empty/zero-safe datasets, not exceptions

## Seed Data

Seeders must create:

- One admin account
- At least six mahasiswa accounts
- At least six student profiles
- Two evaluation periods, including one active current period
- At least three evaluation forms
- At least five question categories
- 15-25 realistic questions
- At least eight completed responses distributed across forms and categories
- Demo credentials documented in README
