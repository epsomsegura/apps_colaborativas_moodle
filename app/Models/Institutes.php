<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institutes extends Model
{
    //
    protected $table = "institutes";
    public $timestamps = true;

    public function n_e(){
        return $this->hasOne('App\Models\Education_Level','id','fk_education_level');
    }
}


