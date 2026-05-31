<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEvaluationFormRequest extends FormRequest
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
            'evaluation_period_id' => ['required', 'integer', Rule::exists('evaluation_periods', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'target_type' => ['required', Rule::in([
                'layanan_akademik',
                'pembelajaran',
                'fasilitas',
                'administrasi',
                'kepuasan_umum',
            ])],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
