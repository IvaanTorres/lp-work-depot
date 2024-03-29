<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/* It's what the teacher creates for the students */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    /* ------------------------------ Relztionships ----------------------------- */
    /* M-1 */
    public function lesson(): BelongsTo {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    // /* 1-M */
    public function uploads(): HasMany {
        return $this->hasMany(Upload::class, 'project_id');
    }

    /* 1-M */
    public function marks(): HasMany {
        return $this->hasMany(Mark::class, 'project_id');
    }
}
