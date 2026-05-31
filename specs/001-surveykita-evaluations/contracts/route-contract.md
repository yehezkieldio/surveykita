# Route Contract: SurveyKita Web Routes

All routes are web/session routes rendered through Blade or redirect responses.
No public JSON API is planned.

## Public/Auth Routes

| Method | Path | Name | Controller Action | Access | Expected Response |
|--------|------|------|-------------------|--------|-------------------|
| GET | `/login` | `login` | `Auth\LoginController@create` | Guest | Login Blade view |
| POST | `/login` | `login.store` | `Auth\LoginController@store` | Guest | Role-based redirect or validation errors |
| POST | `/logout` | `logout` | `Auth\LogoutController@destroy` | Authenticated | Session invalidated, redirect to login |
| GET | `/auth/google/redirect` | `auth.google.redirect` | `Auth\GoogleAuthController@redirect` | Guest | Redirect to Google |
| GET | `/auth/google/callback` | `auth.google.callback` | `Auth\GoogleAuthController@callback` | Guest | Mahasiswa login/link/create or rejection feedback |

## Admin Routes

Middleware: `auth`, `role:admin`.

| Method | Path | Name | Controller Action | Expected Response |
|--------|------|------|-------------------|-------------------|
| GET | `/admin/dashboard` | `admin.dashboard` | `Admin\DashboardController@index` | Admin dashboard |
| GET | `/admin/students` | `admin.students.index` | `Admin\StudentController@index` | Student list |
| GET | `/admin/students/create` | `admin.students.create` | `Admin\StudentController@create` | Student create form |
| POST | `/admin/students` | `admin.students.store` | `Admin\StudentController@store` | Create student/user, redirect |
| GET | `/admin/students/{student}` | `admin.students.show` | `Admin\StudentController@show` | Student detail |
| GET | `/admin/students/{student}/edit` | `admin.students.edit` | `Admin\StudentController@edit` | Student edit form |
| PUT/PATCH | `/admin/students/{student}` | `admin.students.update` | `Admin\StudentController@update` | Update, redirect |
| DELETE | `/admin/students/{student}` | `admin.students.destroy` | `Admin\StudentController@destroy` | Delete or safe block, redirect |
| GET | `/admin/periods` | `admin.periods.index` | `Admin\EvaluationPeriodController@index` | Period list |
| GET | `/admin/periods/create` | `admin.periods.create` | `Admin\EvaluationPeriodController@create` | Period create form |
| POST | `/admin/periods` | `admin.periods.store` | `Admin\EvaluationPeriodController@store` | Create period, redirect |
| GET | `/admin/periods/{period}` | `admin.periods.show` | `Admin\EvaluationPeriodController@show` | Period detail |
| GET | `/admin/periods/{period}/edit` | `admin.periods.edit` | `Admin\EvaluationPeriodController@edit` | Period edit form |
| PUT/PATCH | `/admin/periods/{period}` | `admin.periods.update` | `Admin\EvaluationPeriodController@update` | Update, redirect |
| DELETE | `/admin/periods/{period}` | `admin.periods.destroy` | `Admin\EvaluationPeriodController@destroy` | Delete or safe block, redirect |
| GET | `/admin/forms` | `admin.forms.index` | `Admin\EvaluationFormController@index` | Form list |
| GET | `/admin/forms/create` | `admin.forms.create` | `Admin\EvaluationFormController@create` | Form create form |
| POST | `/admin/forms` | `admin.forms.store` | `Admin\EvaluationFormController@store` | Create form, redirect |
| GET | `/admin/forms/{form}` | `admin.forms.show` | `Admin\EvaluationFormController@show` | Form detail |
| GET | `/admin/forms/{form}/edit` | `admin.forms.edit` | `Admin\EvaluationFormController@edit` | Form edit form |
| PUT/PATCH | `/admin/forms/{form}` | `admin.forms.update` | `Admin\EvaluationFormController@update` | Update, redirect |
| DELETE | `/admin/forms/{form}` | `admin.forms.destroy` | `Admin\EvaluationFormController@destroy` | Delete or safe block, redirect |
| GET | `/admin/categories` | `admin.categories.index` | `Admin\QuestionCategoryController@index` | Category list |
| GET | `/admin/categories/create` | `admin.categories.create` | `Admin\QuestionCategoryController@create` | Category create form |
| POST | `/admin/categories` | `admin.categories.store` | `Admin\QuestionCategoryController@store` | Create category, redirect |
| GET | `/admin/categories/{category}/edit` | `admin.categories.edit` | `Admin\QuestionCategoryController@edit` | Category edit form |
| PUT/PATCH | `/admin/categories/{category}` | `admin.categories.update` | `Admin\QuestionCategoryController@update` | Update, redirect |
| DELETE | `/admin/categories/{category}` | `admin.categories.destroy` | `Admin\QuestionCategoryController@destroy` | Delete or safe block, redirect |
| GET | `/admin/questions` | `admin.questions.index` | `Admin\QuestionController@index` | Question list |
| GET | `/admin/questions/create` | `admin.questions.create` | `Admin\QuestionController@create` | Question create form |
| POST | `/admin/questions` | `admin.questions.store` | `Admin\QuestionController@store` | Create question, redirect |
| GET | `/admin/questions/{question}/edit` | `admin.questions.edit` | `Admin\QuestionController@edit` | Question edit form |
| PUT/PATCH | `/admin/questions/{question}` | `admin.questions.update` | `Admin\QuestionController@update` | Update, redirect |
| DELETE | `/admin/questions/{question}` | `admin.questions.destroy` | `Admin\QuestionController@destroy` | Delete or safe block, redirect |
| GET | `/admin/results` | `admin.results.index` | `Admin\ResultController@index` | Result dashboard |
| GET | `/admin/results/{form}` | `admin.results.show` | `Admin\ResultController@show` | Result detail per form |
| GET | `/admin/results/{form}/export/pdf` | `admin.results.export.pdf` | `Admin\ReportExportController@pdf` | PDF download |
| GET | `/admin/results/{form}/export/excel` | `admin.results.export.excel` | `Admin\ReportExportController@excel` | Excel download |

## Mahasiswa Routes

Base middleware: `auth`, `role:mahasiswa`. Submission routes also use
`student.profile.complete`.

| Method | Path | Name | Controller Action | Expected Response |
|--------|------|------|-------------------|-------------------|
| GET | `/student/dashboard` | `student.dashboard` | `Student\DashboardController@index` | Student dashboard |
| GET | `/student/profile/complete` | `student.profile.edit` | `Student\ProfileController@edit` | Profile completion form |
| POST/PUT | `/student/profile/complete` | `student.profile.update` | `Student\ProfileController@update` | Save profile, redirect |
| GET | `/student/evaluations` | `student.evaluations.index` | `Student\EvaluationController@index` | Active forms list |
| GET | `/student/evaluations/{form}` | `student.evaluations.show` | `Student\EvaluationController@show` | Form detail |
| GET | `/student/evaluations/{form}/submit` | `student.evaluations.fill` | `Student\EvaluationController@fill` | Fill form |
| POST | `/student/evaluations/{form}/submit` | `student.evaluations.submit` | `Student\EvaluationController@submit` | Save response or validation feedback |
| GET | `/student/submissions` | `student.submissions.index` | `Student\SubmissionController@index` | Submission history/status |

## Authorization Outcomes

- Admin on mahasiswa submission routes: blocked with safe feedback.
- Mahasiswa on admin routes: blocked with safe feedback.
- Guest on protected routes: redirected to login.
- Google non-student email: rejected with safe feedback and no account creation.
- Incomplete mahasiswa profile on submission route: redirected to profile
  completion.
