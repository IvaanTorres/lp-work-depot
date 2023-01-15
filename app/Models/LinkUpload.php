<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkUpload extends Model
{
    use HasFactory;

    /* ------------------------------ Relationships ----------------------------- */
    public function uploads(){
        return $this->morphToMany(Upload::class, 'uploadable');
    }
}
