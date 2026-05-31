<?php

namespace App\Http\Requests\Admin;

use App\Services\NimParser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use InvalidArgumentException;

class StoreStudentRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'nim' => ['required', 'digits:7', Rule::unique('students', 'nim')],
            'class_name' => ['required', 'string', 'max:50'],
            'password' => ['required', Password::min(8)],
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
