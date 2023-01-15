<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    /* -------------------------------- Functions ------------------------------- */
    public function sanitizeFilename($filename) {
        $filename = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        return $filename;
    }

    /* ----------------------------- Relationships ----------------------------- */
    /* Get all from Upload */
    public function uploads(){
        return $this->morphToMany(Upload::class, 'uploadable');
    }
}
