<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* -------------------------------- Functions ------------------------------- */
    public function hasRole($role) {
        return $this->role()->first()->value == $role;
    }

    public static function getUsersOfCourse($course_id, $role = null){
        $students = null;
        if($role){
            $students = Role::where('value', $role)->first()->users()
                ->where(function($query) use ($course_id){
                    // Get the resulted users associated to the course
                    $query->whereHas('courses', function($query) use ($course_id){
                        $query->where('course_id', $course_id);
                    });
                });
        }else{
            $students = User::where(function($query) use ($course_id){
                // Get the resulted users associated to the course
                $query->whereHas('courses', function($query) use ($course_id){
                    $query->where('course_id', $course_id);
                });
            });
        }
        return $students;
    }

    /* ------------------------------ Relationships ----------------------------- */
    /* 1-M */
    public function role(): BelongsTo {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /* M-M */
    public function courses(): BelongsToMany {
        return $this->belongsToMany(Course::class, 'user_course');
    }

    /* 1-M */
    public function uploads(): HasMany {
        return $this->hasMany(Upload::class, 'user_id');
    }

    /* 1-M */
    public function marks(): HasMany {
        return $this->hasMany(Mark::class, 'user_id');
    }
}
