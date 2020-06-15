<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteClasses extends Model
{
    //
    protected $table = 'institute_classes';
    public $timestamps = true;

    protected $fillable = ['fk_institute','fk_class','classgrade','status','action_id'];

    public function ic_i(){
        return $this->hasOne('\App\Models\Institutes','id','fk_institute');
    }

    public function ic_c(){
        return $this->hasOne('\App\Models\Classes','id','fk_class');
    }
}
