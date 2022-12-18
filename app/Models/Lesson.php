<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    // /* M-1 */
    // public function course(): BelongsTo {
    //     return $this->belongsTo(Course::class);
    // }

    // /* 1-M */
    // public function projects(): HasMany {
    //     return $this->hasMany(Project::class);
    // }
}
