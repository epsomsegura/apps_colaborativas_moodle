<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitiesStudents extends Model
{
    //
    protected $table ="activities_students";
    public $timestamps = true;

    protected $fillable = [];

    public function ast_a(){
        return $this->hasOne('\App\Models\Activities','id','fk_activity');
    }
    public function ast_st(){
        return $this->hasOne('\App\Models\StudentsExpedients','id','fk_student');
    }
}
