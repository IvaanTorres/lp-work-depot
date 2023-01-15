<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    /* -------------------------------- Functions ------------------------------- */
    public function getUserById($user_id){
        return $this->users()->where('user_id', $user_id)->first() ?? false;
    }
    public function getTeacherById($user_id){
        $user = $this->users()->where('user_id', $user_id)->first();
        if($user){
            $user_role = $user->role->value;
            return $user_role == Roles::Teacher->value;
        }
        return false;
    }
    public function getStudentById($user_id){
        $user = $this->users()->where('user_id', $user_id)->first();
        if($user){
            $user_role = $user->role->value;
            return $user_role == Roles::Student->value;
        }
        return false;
    }

    /* ------------------------------ Realtionships ----------------------------- */
    /* M-M */
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_course');
    }

    /* 1-M */
    public function lessons(): HasMany {
        return $this->hasMany(Lesson::class);
    }
}
