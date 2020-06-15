<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \App\Models\Institutes;

class Users extends Model
{
    //
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = ['name','email','password'];

    public function u_r(){
        return $this->hasOne('\App\Models\Roles','id','fk_role');
    
    }
    public function u_i(){
        return $this->hasOne('\App\Models\Institutes','id','fk_institute');
    }
    public function u_se(){
        return $this->belongsTo('\App\Models\StudentsExpedients','fk_student','id');
    }
}
