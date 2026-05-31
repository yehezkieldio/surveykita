# Report Contract: SurveyKita PDF and Excel Exports

Reports are admin-only and are generated from the same
`EvaluationResultService` output as dashboards.

## Shared Filter Context

Reports must include the applied context:

- Evaluation form
- Evaluation period
- Optional category filter
- Generated timestamp
- Empty-result state when applicable

## PDF Report

Route: `GET /admin/results/{form}/export/pdf`

Controller: `Admin\ReportExportController@pdf`

Template: `resources/views/pdf/evaluation-report.blade.php`

Required contents:

- Evaluation title
- Period name, semester, academic year, start date, end date
- Applied filters
- Total respondents
- Total answers
- Average score
- Satisfaction percentage
- Satisfaction category
- Result per category
- Result per question
- Likert score distribution
- Suggestions/comments

Empty result rule:

- PDF still downloads for admin users.
- Summary values are zero-safe.
- Tables show headers and empty-state rows.
- Suggestions section states that no suggestions are available.

## Excel Report

Route: `GET /admin/results/{form}/export/excel`

Controller: `Admin\ReportExportController@excel`

Export class: `App\Exports\EvaluationReportExport`

Required sheets:

1. `Summary`
   - Form title
   - Period
   - Applied filters
   - Total respondents
   - Total answers
   - Average score
   - Satisfaction percentage
   - Satisfaction category
2. `Category Recap`
   - Category name
   - Total answers
   - Average score
   - Satisfaction percentage
   - Satisfaction category
3. `Question Recap`
   - Question text
   - Category
   - Total answers
   - Average score
   - Satisfaction percentage
4. `Likert Distribution`
   - Score 1-5
   - Label
   - Count
   - Percentage
5. `Suggestions`
   - Submitted at
   - Student NIM or safe identifier
   - Form title
   - Suggestion/comment
6. `Raw Responses`
   - Response ID
   - Submitted at
   - Student NIM or safe identifier
   - Form title
   - Question
   - Category
   - Score
   - Score label
   - Suggestion/comment

Empty result rule:

- Workbook still downloads for admin users.
- Every sheet includes headers.
- Summary sheet contains zero-safe values.
- Recap, distribution, suggestions, and raw-response sheets contain empty-state
  rows or zero counts as appropriate.
