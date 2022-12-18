<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    /* Get all from Upload */
    // public function uploads(){
    //     return $this->morphOne(Upload::class, 'uploadable');
    // }
}
