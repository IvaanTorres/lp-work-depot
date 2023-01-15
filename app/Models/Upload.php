<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upload extends Model
{
    use HasFactory;

    /* ------------------------------ Relationships ----------------------------- */
    /* M-1 */
    public function project(): BelongsTo {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /* M-1 */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* It offers a kind of inheritance for the types of uploads the user can upload */
    public function links(){
        return $this->morphedByMany(LinkUpload::class, 'uploadable');
    }
    /* It offers a kind of inheritance for the types of uploads the user can upload */
    public function files(){
        return $this->morphedByMany(FileUpload::class, 'uploadable');
    }
}
