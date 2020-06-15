<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsExpedients extends Model
{
    //
    protected $table = 'students_expedients';
    public $timestamps = true;

    protected $fillable=['fk_institute'];

    public function se_stud(){
        return $this->hasOne('\App\Models\Users','id','fk_student');
    }

    public function se_prnt(){
        return $this->hasOne('\App\Models\Users','id','fk_parent');
    }

    public function se_inst(){
        return $this->hasOne('\App\Models\Institutes','id','fk_institute');
    }
}
