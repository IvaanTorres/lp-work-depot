<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upload extends Model
{
    use HasFactory;

    /* M-1 */
    // public function project(): BelongsTo {
    //     return $this->belongsTo(Project::class);
    // }

    // /* M-1 */
    // public function user(): BelongsTo {
    //     return $this->belongsTo(User::class);
    // }

    // /* It offers a kind of inheritance for the types of uploads the user can upload */
    // public function uploadable(){
    //     return $this->morphTo();
    // }
}
