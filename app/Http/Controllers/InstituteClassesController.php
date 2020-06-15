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
use \App\Models\Classes as C;
use \App\Models\Institutes as I;
use \App\Models\InstituteClasses as IC;
use \App\Models\StudentsExpedients as SE;
use \App\Models\TeachersExpedients as TE;
use \App\Models\Zipcodes as ZC;

class InstituteClassesController extends Controller
{
    //  Admin classes
    public function index(Request $r){
        $p=NULL;
        $q=NULL;
        $data['c'] = [];

        if(Auth::user()->fk_role == 1)
            $q = IC::with(['ic_i','ic_c'])->select('id','fk_institute','fk_class','shift')->groupBy('fk_class','fk_institute','shift')->get();
        else
            $q = IC::with(['ic_i','ic_c'])->where('fk_institute',Auth::user()->fk_institute)->select('id','fk_institute','fk_class','shift')->groupBy('fk_class','fk_institute','shift')->get();

        foreach($q as $i){
            $i->grades = IC::Where(['fk_institute'=>$i->fk_institute,'fk_class'=>$i->fk_class,'shift'=>$i->shift,'status'=>1])->select('classgrade','status')->groupBy('classgrade')->get();
            $i->groups = IC::Where(['fk_institute'=>$i->fk_institute,'fk_class'=>$i->fk_class,'shift'=>$i->shift,'status'=>1])->select('classgroup','status')->groupBy('classgroup')->get();
            $p[] = $i;
        }
        
        $data['c'] = $p;
        
        return View('institute_classes.index',$data);
    }

    public function newInstituteClass(Request $r){
        SofTeacher::ActionLog($r);
        $data=[];
        if(Auth::user()->fk_institute == NULL)
            $data['states'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->get();
        else
            $data['institute'] = I::Where('id',Auth::user()->fk_institute)->first();

        return View('institute_classes.create',$data);
    }

    public function saveInstituteClass(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $obj_insert = [];
        $grades = I::find($r->fk_institute)->grades;
        $groups = I::find($r->fk_institute)->groups;

        for($i=1;$i<=$grades;$i++){    
            for($j=1;$j<=$groups;$j++){
                $obj_insert[] = [
                    'fk_institute'=>$r->fk_institute,
                    'fk_class'=>$r->fk_class,
                    'shift' => $r->shift,
                    'classgrade'=>$i,
                    'classgroup'=>$j,
                    'status'=>(in_array($i,$r->classgrade) && in_array($j,$r->classgroup)) ? 1 : 0,
                    'action_id'=>$action_id
                ];
            }
        }

        DB::Begintransaction();
        try{
            IC::insert($obj_insert);
            DB::commit();
            return \Redirect::to('/institute_classes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico'.$e->getMessage()]);
        }
    }

    public function editInstituteClass(Request $r,$id){
        $id=Crypt::decrypt($id);

        $data['u'] = IC::With(['ic_i','ic_c'])->Where('id',$id)->first();

        if(Auth::user()->fk_institute == NULL){
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();
            $data['idEst'] = ZC::where('cp',$data['u']->ic_i->zipcode)->first()->idEstado;
            $data['m'] = ZC::groupBy('idMunicipio','municipio')->where('idEstado',$data['idEst'])->select('idMunicipio as id','municipio')->orderBy('municipio','ASC')->get();
            $data['idMun'] = ZC::where('cp',$data['u']->ic_i->zipcode)->first()->idMunicipio; 
            $idMun = $data['idMun'];
            $data['ins'] = I::with(['zc_i'=>function($q) use ($idMun){
                $q->where('idMunicipio',$idMun)->get();
            }])->orderBy('name','ASC')->get();
        }
        else{            
            $q = I::findOrFail(Auth::user()->fk_institute);
            $data['ins'] = Auth::user()->fk_institute;
            $data['institute'] = $q;
        }

        $data['ic'] = IC::findOrFail($id);

        return View('institute_classes.edit',$data);
    }

    public function upgradeInstituteClass(Request $r, $id){
        $id=Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);
        $ic_data = IC::Where('id',$id)->select('fk_institute','fk_class')->first();    
        $grades = I::find($ic_data->fk_institute)->grades;
        $groups = I::find($ic_data->fk_institute)->groups;

        DB::Begintransaction();
        try{
            for($i=1;$i<=$grades;$i++){
                for($j=1;$j<=$groups;$j++){
                    $objupdate = [
                        'status'=>(in_array($i,$r->classgrade) && in_array($j,$r->classgroup)) ? 1 : 0,
                        'shift' => $r->shift,
                        'action_id'=>$action_id
                    ];
                    IC::Where(['fk_institute'=>$ic_data->fk_institute,'fk_class'=>$ic_data->fk_class,'classgrade'=>$i,'classgroup'=>$j])->update($objupdate);
                }
            }
            
            DB::commit();
            return \Redirect::to('/institute_classes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteInstituteClass(Request $r, $id){
        SofTeacher::ActionLog($r);

        $id=Crypt::decrypt($id);
        $ic = IC::find($id);
        DB::Begintransaction();
        try{
            IC::Where(['fk_institute'=>$ic->fk_institute,'fk_class'=>$ic->fk_class])->delete();
            DB::commit();
            return \Redirect::To('/institute_classes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }


    public function assignmentTeacher(Request $r){
        SofTeacher::ActionLog($r);

        $ic=NULL;
        $ic_ol=NULL;

        if(Auth::user()->fk_role==1){
            $ic=IC::Where('status',1)->get();
        }
        else{
            $ic=IC::Where(['status'=>1,'fk_institute'=>Auth::user()->fk_institute])->get();
        }

        foreach($ic as $i){
            $i->teachers = TE::With(['te_teach','te_prof'])
            ->Where([
                'status'=>1,
                'fk_institute' => $i->fk_institute
            ])
            ->get();
            $ic_ol[]=$i;
        }

        $data['ic'] = $ic_ol;

        return View('institute_classes.assignment',$data);

    }

    public function saveAssignmentTeacher(Request $r,$id,$fk_teacher){
        $action_id = SofTeacher::ActionLog($r);
        
        if(IC::Where('id',$id)->update(['fk_teacher'=>$fk_teacher,'action_id'=>$action_id]))
            return response()->json('OK');
        else
            return response()->json('NO');

    }

    public function studentsClasses(Request $r){
        SofTeacher::ActionLog($r);

        $ic=NULL;
        $ic_ol=NULL;

        if(Auth::user()->fk_role==1){
            $ic=IC::Where('status',1)->get();
        }
        else{
            $ic=IC::Where(['status'=>1,'fk_institute'=>Auth::user()->fk_institute])->get();
        }

        foreach($ic as $i){
            $i->total = SE::With(['se_stud'])
            ->Where([
                'status'=>1,
                'fk_institute' => $i->fk_institute,
                'grade' => $i->classgrade,
                'group_class' => $i->classgroup
            ])
            ->count();
            $i->list = json_encode(SE::With(['se_stud'=>function($q){$q->where('status',1)->select('id','name')->orderBy('name','ASC');}])
            ->Where([
                'status'=>1,
                'fk_institute' => $i->fk_institute,
                'grade' => $i->classgrade,
                'group_class' => $i->classgroup
            ])
            ->select('id','fk_student')
            ->get(),JSON_UNESCAPED_UNICODE);
            $ic_ol[]=$i;
        }

        $data['ic'] = $ic_ol;

        return View('institute_classes.students',$data);   
    }
    
    public function teacherClasses(Request $r){
        SofTeacher::ActionLog($r);

        $ic=NULL;
        $ic_ol=NULL;

        $ic=IC::With(['ic_i'=>function($q){$q->select('id','name');}])->Where(['status'=>1,'fk_teacher'=>Auth::id()])->get();
        
        foreach($ic as $i){
            $i->total = SE::With(['se_stud'])
            ->Where([
                'status'=>1,
                'fk_institute' => $i->fk_institute,
                'grade' => $i->classgrade,
                'group_class' => $i->classgroup
            ])
            ->count();
            $i->list = json_encode(SE::With(['se_stud'=>function($q){$q->where('status',1)->select('id','name')->orderBy('name','ASC');}])
            ->Where([
                'status'=>1,
                'fk_institute' => $i->fk_institute,
                'grade' => $i->classgrade,
                'group_class' => $i->classgroup
            ])
            ->select('id','fk_student')
            ->get(),JSON_UNESCAPED_UNICODE);
            $ic_ol[]=$i;
        }

        $data['ic'] = $ic_ol;

        return View('institute_classes.teacher',$data);   
    }
}
