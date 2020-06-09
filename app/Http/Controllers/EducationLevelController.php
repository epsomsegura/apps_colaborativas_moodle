<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lib\SofTeacher;



// Models
use App\Models\Education_Level as EL;

class EducationLevelController extends Controller
{
    //
    public function index(Request $r){
        $data['el'] = EL::all();

        SofTeacher::ActionLog($r);
        return View('education_level.index', $data);
    }
}
