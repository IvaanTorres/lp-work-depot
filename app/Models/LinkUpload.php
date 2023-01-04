<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkUpload extends Model
{
    use HasFactory;

    // public function delete(){
    //    $res=parent::delete();
    //    if($res==true){
    //         $relations=$this->youRelation; // here get the relation data
    //         // delete Here
    //     }
    // }

    /* Get all from Upload */
    public function uploads(){
        return $this->morphToMany(Upload::class, 'uploadable');
    }
}
