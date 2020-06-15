<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    //
    protected $table = 'activities';
    public $timestamps = true;

    public function a_i(){
        return $this->hasOne('\App\Models\Institutes','id','fk_institute');
    }
    public function a_ic(){
        return $this->hasOne('\App\Models\InstituteClasses','id','fk_class');
    }
    public function a_t(){
        return $this->hasOne('\App\Models\Users','id','fk_teacher');
    }
}
