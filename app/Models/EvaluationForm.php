<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @param  Builder<EvaluationForm>  $query
     */
    public function scopeActiveForStudent(Builder $query): void
    {
        $query->where('is_active', true)
            ->whereHas('evaluationPeriod', fn ($query) => $query->active()
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now()));
    }

    public function canBeFilledBy(?Student $student = null): bool
    {
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
