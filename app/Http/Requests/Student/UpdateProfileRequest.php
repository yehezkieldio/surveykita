<?php

namespace App\Http\Requests\Student;

use App\Models\Student;
use App\Services\NimParser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isMahasiswa() ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Student|null $student */
        $student = $this->user()?->student;

        return [
            'nim' => ['required', 'digits:7', Rule::unique('students', 'nim')->ignore($student)],
            'name' => ['required', 'string', 'max:255'],
            'class_name' => ['required', 'string', 'max:50'],
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
