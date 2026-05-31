# UI Contract: SurveyKita Blade Interface

## Layouts

- `layouts.guest`: login and OAuth feedback pages.
- `layouts.admin`: admin navigation for dashboard, students, periods, forms,
  categories, questions, results, exports, and logout.
- `layouts.student`: mahasiswa navigation for dashboard, profile, evaluations,
  submissions, and logout.

## Shared Components

- `components.card`: summary cards and dashboard widgets.
- `components.table`: paginated admin tables and result tables.
- `components.badge`: role, active/inactive, submitted/unsubmitted, category.
- `components.button`: links and form submit buttons with variants.
- `components.alert`: success, warning, error, info feedback.
- `components.empty-state`: no records/no responses/no submissions.
- `components.form-error`: field-level validation feedback.
- `components.pagination`: Laravel pagination links styled with Tailwind.
- `components.chart-panel`: ApexCharts containers fed by real chart objects.

## UI Rules

- All labels and feedback use Indonesian wording.
- Every visible link/button targets an implemented named route or submits a real
  form.
- Empty states are explicit and do not pretend that data exists.
- Admin pages expose create/edit/delete/detail actions only where the route and
  controller action exist.
- Mahasiswa evaluation fill pages show each required question with Likert
  labels:
  - 1: Sangat Tidak Puas
  - 2: Tidak Puas
  - 3: Cukup Puas
  - 4: Puas
  - 5: Sangat Puas
- Responsive behavior must keep tables usable on mobile through horizontal
  overflow or stacked summaries.
- No Bootstrap classes, React/Vue/Inertia/Livewire components, or admin panel
  generated UI are allowed.

## Page Inventory

### Public/Auth

- Login page
- Non-student Google email rejection feedback
- Unauthorized feedback/error state

### Admin

- Dashboard
- Student list/create/edit/detail/delete
- Evaluation period list/create/edit/detail/delete
- Evaluation form list/create/edit/detail/delete
- Question category list/create/edit/delete
- Question list/create/edit/delete
- Result dashboard
- Result detail per form
- PDF export action
- Excel export action

### Mahasiswa

- Dashboard
- Profile completion
- Active evaluation forms list
- Evaluation form detail
- Evaluation fill page
- Submission success
- Submission status/history

## Chart Contract

Dashboard charts use service output:

- Overall satisfaction percentage per form: bar/column chart.
- Average score per category: bar chart.
- Respondent count per form: bar chart.
- Likert score distribution 1-5: bar or donut chart.

No chart may use hardcoded placeholder data in final implementation.
