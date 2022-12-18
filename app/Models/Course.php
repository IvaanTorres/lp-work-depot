<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /* M-M */
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_course');
    }

    // /* 1-M */
    // public function lessons(): HasMany {
    //     return $this->hasMany(Lesson::class);
    // }
}
