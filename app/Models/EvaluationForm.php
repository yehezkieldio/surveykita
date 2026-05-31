<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'evaluation_period_id',
    'title',
    'description',
    'target_type',
    'is_active',
])]
class EvaluationForm extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function isFillable($key = null): bool
    {
        if (is_string($key)) {
            return parent::isFillable($key);
        }

        $student = $key instanceof Student ? $key : null;
        $period = $this->relationLoaded('evaluationPeriod')
            ? $this->evaluationPeriod
            : $this->evaluationPeriod()->first();

        if (! $this->is_active || ! $period?->isCurrentlyOpen()) {
            return false;
        }

        if (! $student) {
            return true;
        }

        return ! $this->responses()
            ->whereBelongsTo($student)
            ->exists();
    }

    /**
     * @return BelongsTo<EvaluationPeriod, $this>
     */
    public function evaluationPeriod(): BelongsTo
    {
        return $this->belongsTo(EvaluationPeriod::class);
    }

    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<Response, $this>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
