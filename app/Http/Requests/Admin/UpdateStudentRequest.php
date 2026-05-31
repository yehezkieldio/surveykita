<?php

namespace App\Http\Requests\Admin;

use App\Models\Student;
use App\Services\NimParser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use InvalidArgumentException;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Student $student */
        $student = $this->route('student');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user_id)],
            'nim' => ['required', 'digits:7', Rule::unique('students', 'nim')->ignore($student)],
            'class_name' => ['required', 'string', 'max:50'],
            'password' => ['nullable', Password::min(8)],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->has('nim')) {
                    return;
                }

                try {
                    app(NimParser::class)->parse((string) $this->input('nim'));
                } catch (InvalidArgumentException $exception) {
                    $validator->errors()->add('nim', $exception->getMessage());
                }
            },
        ];
    }
}
