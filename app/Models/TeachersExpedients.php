<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachersExpedients extends Model
{
    //
    protected $table = 'teachers_expedients';
    public $timestamps = true;

    protected $fillable=['fk_institute'];

    public function te_teach(){
        return $this->hasOne('\App\Models\Users','id','fk_teacher');
    }
    
    public function te_prof(){
        return $this->hasOne('\App\Models\Profiles','id','fk_profile');
    }

    public function te_inst(){
        return $this->hasOne('\App\Models\Institutes','id','fk_institute');
    }
}
