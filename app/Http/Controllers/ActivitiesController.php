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
use \App\Models\ActivitiesStudents as ASt;
use \App\Models\Institutes as I;
use \App\Models\InstituteClasses as IC;
use \App\Models\StudentsExpedients as SE;
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
                $query=$act->orderBy('id','DESC')->get();
            break;
            case 2: 
                $query=$act->where('fk_institute',Auth::user()->fk_institute)->orderBy('id','DESC')->get();
            break;
            case 3: 
                $query=$act->where('fk_teacher',Auth::user()->id)->orderBy('id','DESC')->orderBy('id','DESC')->get();
            break;
            case 5:
                $data['ast'] = ASt::WhereHas('ast_st',function($q){$q->where('fk_student',Auth::user()->id);})->orderBy('id','DESC')->get();
                
                return View('activities.student',$data);
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
                $data['ins'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->groupBy('fk_institute')->get();
                $data['d'] = TE::With(['te_teach'=>function($r){$r->select('id','name');}])->groupBy('fk_teacher')->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->WhereNotNull('fk_teacher')->groupBy('fk_teacher','fk_institute','classgrade','classgroup')->get();
            break;
            case 2: 
                $data['d'] = TE::With(['te_teach'=>function($r){$r->select('id','name');}])->Where('fk_institute',Auth::user()->fk_institute)->groupBy('fk_teacher')->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->WhereNotNull('fk_teacher')->Where('fk_institute',Auth::user()->fk_institute)->groupBy('fk_teacher','fk_institute','classgrade','classgroup')->get();
            break;
            case 3: 
                $data['ins'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->WhereNotNull('fk_teacher')->where('fk_teacher',Auth::user()->id)->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->Where('fk_teacher',Auth::user()->id)->get();
            break;
        }

        return View('activities.create',$data);        
    }

    public function saveActivity(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','startend','shift');



        $data['fk_class'] = $r->fk_class;
        $data['status'] = 1;
        $data['start'] = explode(' - ',$r->startend)[0];
        $data['end'] = explode(' - ',$r->startend)[1];
        $data['action_id'] = $action_id;

        if($r->hasFile('file_request')){
            $file = $r->file('file_request');
            $institute = $r->fk_institute;
            $shift = $r->shift;
            $class = $r->fk_class;
            $teacher = $r->fk_teacher;

            $upload_path = $institute.'/'.$shift.'/'.$class.'/'.$teacher;

            $name = $file->getClientOriginalName();
            $path = $file->storeAs($upload_path,$name,'uploads');

            $data['file_request']='uploads/'.$path.$name;
        }

        $id_activity = A::insertGetId($data);


        $cr = IC::find(['id'=>$r->fk_class])->first();

        $students = SE::Where(['fk_institute'=>$r->fk_institute,'shift'=>$cr->shift,'grade'=>$cr->classgrade,'group_class'=>$cr->classgroup])->select('id')->get();

        $oas = [];
        foreach($students as $s){
            $oas[]=[
                'fk_activity' => $id_activity,
                'fk_student' => $s->id,
                'status' => 0,
                'action_id' =>$action_id
            ];
        }

        ASt::insert($oas);
        
        
        return \Redirect::To('/activities');
    }


    public function editActivity(Request $r,$id){
        $id=Crypt::decrypt($id);
        SofTeacher::ActionLog($r);

        $data['a']=A::With(['a_ic'])->Where('id',$id)->first();

        switch(Auth::user()->fk_role){
            case 1: 
                $data['ins'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->groupBy('fk_institute')->get();
                $data['d'] = TE::With(['te_teach'=>function($r){$r->select('id','name');}])->groupBy('fk_teacher')->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->WhereNotNull('fk_teacher')->groupBy('fk_teacher','fk_institute','classgrade','classgroup')->get();
            break;
            case 2: 
                $data['d'] = TE::With(['te_teach'=>function($r){$r->select('id','name');}])->Where('fk_institute',Auth::user()->fk_institute)->groupBy('fk_teacher')->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->WhereNotNull('fk_teacher')->Where('fk_institute',Auth::user()->fk_institute)->groupBy('fk_teacher','fk_institute','classgrade','classgroup')->get();
            break;
            case 3: 
                $data['ins'] = TE::With(['te_inst'=>function($p){$p->select('id','name');}])->WhereNotNull('fk_teacher')->where('fk_teacher',Auth::user()->id)->get();
                $data['c'] = IC::With(['ic_c'=>function($q){$q->select('id','classname');}])->Where('fk_teacher',Auth::user()->id)->get();
            break;
        }

        return View('activities.edit',$data);        
    }


    public function scoresActivity(Request $r,$id){
        $id = Crypt::decrypt($id);
        
        if(date('Y-m-d H:i:s') > A::Where('id',$id)->first()->end){
            A::Where('id',$id)->update(['status'=>0]);
            ASt::Where('fk_activity',$id)->update(['status'=>2]);
        }
        
        $q=ASt::With([
            'ast_a'=>function($p){
                $p->with([
                    'a_i'=>function($p1){$p1->select('id','name');},
                    'a_ic'=>function($p1){$p1->with(['ic_c'=>function($p1_1){$p1_1->select('id','classname');}])->select('id','fk_class');},
                    ])->select('id','fk_institute','fk_class','instruction','request','status');
            },
            'ast_st'=>function($q){$q->with(['se_stud'=>function($q1){$q1->select('id','name');}])->select('id','fk_student');}
            ])->Where('fk_activity',$id)->orderBy('id','DESC')->get();
        
        $data['ast']=$q;

        return View('activities.scores',$data);
    }

    public function saveScoresActivity(Request $r,$id){
        $action_id=SofTeacher::ActionLog($r);
        $id = Crypt::decrypt($id);

        $ast = ASt::Where('id',$id)->first();
        $data = $r->except('_token','_method');
        $data['status']=2;
        $data['score']=$r->score;
        $data['feedback']=$r->feedback;
        $data['action_id']=$action_id;

        ASt::Where('id',$id)->update($data);

        return response()->json('OK');
    }

    public function sendActivity(Request $r,$id){
        $id = Crypt::decrypt($id);
        
        if(date('Y-m-d H:i:s') > A::Where('id',$id-1)->first()->end){
            A::Where('id',$id)->update(['status'=>0]);
            ASt::Where('fk_activity',$id)->update(['status'=>2]);
        }
        
        $q=ASt::With([
            'ast_a'=>function($p){
                $p->with([
                    'a_i'=>function($p1){$p1->select('id','name');},
                    'a_ic'=>function($p1){$p1->with(['ic_c'=>function($p1_1){$p1_1->select('id','classname');}])->select('id','fk_class');},
                    ])->select('id','fk_institute','fk_class','instruction','request','status');
            },
            'ast_st'=>function($q){$q->with(['se_stud'=>function($q1){$q1->select('id','name');}])->select('id','fk_student');}
            ])->Where('id',$id)->first();
        
        $data['ast']=$q;

        return View('activities.send',$data);
    }

    public function saveSendActivity(Request $r,$id){
        $action_id=SofTeacher::ActionLog($r);
        $id = Crypt::decrypt($id);
        $id--;
        
        if(date('Y-m-d H:i:s') > A::Where('id',$id)->first()->end){
            A::Where('id',$id)->update(['status'=>0]);
            ASt::Where('id',$id)->update(['status'=>2]);
        }
        else{
            $ast = ASt::Where('id',$id)->first();
            $act = A::With('a_ic')->Where('id',$ast->fk_activity)->first();
            $data = $r->except('_token','_method');

            if($r->hasFile('file_response')){
                $file = $r->file('file_response');
                $institute = $act->fk_institute;
                $shift = $act->a_ic->shift;
                $class = $act->fk_class;
                $teacher = $act->fk_teacher;
                $student = Auth::user()->id;
    
                $upload_path = $institute.'/'.$shift.'/'.$class.'/'.$teacher.'/'.$id.'/'.$student;
    
                $name = $file->getClientOriginalName();
                $path = $file->storeAs($upload_path,$name,'uploads');
    
                $data['file_response']='uploads/'.$path;
            }
            $data['status']=1;


            ASt::Where('id',$id)->update($data);

            return \Redirect::To('/activities');
        }
    }
}
