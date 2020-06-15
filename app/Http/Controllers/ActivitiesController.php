<?php

namespace App\Http\Controllers;

// Packages
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;

// Libs
use \App\Lib\SofTeacher;

// Models
use \App\Models\Activities as A;
use \App\Models\Institutes as I;
use \App\Models\InstituteClasses as IC;
use \App\Models\TeachersExpedients as TE;

class ActivitiesController extends Controller
{
    //
    public function index(Request $r){
        SofTeacher::ActionLog($r);

        $query = NULL;
        $act = A::With([
            'a_i'=>function($p){$p->select('id','name');},
            'a_ic'=>function($r){$r->with(['ic_c'=>function($s){$s->select('id','classname');}]);},
            'a_t'=>function($q){$q->select('id','name');},
            ]);

        switch(Auth::user()->fk_role){
            case 1: 
                $query=$act->get();
            break;
            case 2: 
                $query=$act->where('fk_institute',Auth::user()->fk_institute)->get();
            break;
            case 3: 
                $query=$act->where('fk_teacher',Auth::user()->id)->get();
            break;
        }


        $data['a']=$query;

        return View('activities.index',$data);
    }

    public function newActivity(Request $r){
        SofTeacher::ActionLog($r);

        $data=NULL;

        switch(Auth::user()->fk_role){
            case 1: 
                $data['i'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->groupBy('fk_institute')->get();
                $data['d'] = TE::With(['te_teach'=>function($r){$r->select('id','name');}])->groupBy('fk_teacher')->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->whereNotNull('fk_teacher')->groupBy('fk_teacher')->get();
            break;
            case 2: 
                $data['d']=I::Where('status',1)->get();
            break;
            case 3: 
                $data['i'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->where('fk_teacher',Auth::user()->id)->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->Where('fk_teacher',Auth::user()->id)->groupBy('fk_institute')->get();
            break;
        }

        return View('activities.create',$data);        
    }
}
