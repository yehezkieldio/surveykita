<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'nim',
    'name',
    'program_code',
    'study_program',
    'enrollment_year',
    'sequence_number',
    'class_name',
    'class_name_confirmed',
])]
class Student extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'enrollment_year' => 'integer',
            'class_name_confirmed' => 'boolean',
        ];
    }

    public function isComplete(): bool
    {
        return filled($this->nim)
            && filled($this->name)
            && filled($this->program_code)
            && filled($this->study_program)
            && filled($this->enrollment_year)
            && filled($this->sequence_number)
            && filled($this->class_name)
            && $this->class_name_confirmed;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Response, $this>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
