<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'semester',
    'academic_year',
    'start_date',
    'end_date',
    'is_active',
])]
class EvaluationPeriod extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function isCurrentlyOpen(): bool
    {
        $today = now()->toDateString();

        return $this->is_active
            && $this->start_date->toDateString() <= $today
            && $this->end_date->toDateString() >= $today;
    }

    /**
     * @return HasMany<EvaluationForm, $this>
     */
    public function evaluationForms(): HasMany
    {
        return $this->hasMany(EvaluationForm::class);
    }
}
