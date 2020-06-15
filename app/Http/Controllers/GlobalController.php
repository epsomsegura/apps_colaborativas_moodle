<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

// Libs
use App\Lib\SofTeacher;

// Models
use \App\Models\Classes as C;
use \App\Models\Institutes as I;
use \App\Models\InstituteClasses as IC;
use \App\Models\Profiles as P;
use \App\Models\Users as U;
use App\Models\Zipcodes as ZC;

class GlobalController extends Controller
{
    //  GET CLASS GRADES JSON BY CLASS
    public function classGrades(Request $r, $fk_institute, $fk_class,$shift){
        $grade =IC::Where(['fk_institute'=>$fk_institute,'fk_class'=>$fk_class,'shift'=>$shift,'status'=>1])->select('classgrade','status')->groupBy('classgrade')->get();
        $group =IC::Where(['fk_institute'=>$fk_institute,'fk_class'=>$fk_class,'shift'=>$shift,'status'=>1])->select('classgroup','status')->groupBy('classgroup')->get();

        $data=[
            'classgrade'=>$grade,
            'classgroup'=>$group,
        ];
        return response()->json($data,200);
    }

    //  GET CLASSES SUGGESTION JSON BY COINCIDENCE
    public function classSuggestion(Request $r, $word){
        SofTeacher::ActionLog($r);
        $q = C::Where('classname','LIKE','%'.strtolower($word).'%')->select('id','classname')->get();

        return response()->json($q,200);
    }

    //  GET COUNTIES JSON BY STATE
    public function countiesByState(Request $r,$id){
        SofTeacher::ActionLog($r);

        $q = ZC::Where('idEstado',$id)->groupBy('idMunicipio','municipio')->select('idMunicipio as id','municipio')->orderBy('municipio','ASC')->get();

        return response()->json($q,200);
    }

    //  GET INSTITUTES JSON BY COUNTY
    public function institutesByCounty(Request $r, $id){
        SofTeacher::ActionLog($r);

        $q = I::with(['zc_i'=>function($q) use ($id){
            $q->where('idMunicipio',$id)->get();
        }])->select('id','name')->orderBy('name','ASC')->get();

        return response()->json($q,200);    
    }

    // GET INSTITUTE DATA JSON BY ID
    public function instituteData(Request $r, $id){
        $q = I::find($id);

        $data=[
            'instituteData' => $q,
            'groups' => SofTeacher::groupLetter($q->groups)
        ];

        return response()->json($data,200);
    }

    //  GET CLASSES SUGGESTION JSON BY COINCIDENCE
    public function profileSuggestion(Request $r, $word){
        SofTeacher::ActionLog($r);
        $q = P::Where('profile','LIKE','%'.strtolower($word).'%')->select('id','profile')->get();

        return response()->json($q,200);
    }

    //  GET NEW CLASSNAME ID
    public function saveClassSuggestion(Request $r){
        $action_id = SofTeacher::ActionLog($r);
        $c = new C();

        $c->classname = $r->classname;
        $c->description = $r->description;
        $c->status = 1;
        $c->action_id = $action_id;

        DB::Begintransaction();
        try{
            if($c->save()){
                DB::commit();
                return response()->json($c,200);
            }
            else{
                DB::rollback();
                return response()->json('Error',500);
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json('Error general '.$e->getMessage(),500);
        }
    }
    //  GET NEW CLASSNAME ID
    public function saveProfileSuggestion(Request $r){
        $action_id = SofTeacher::ActionLog($r);
        $p = new P();

        $p->profile = $r->profile;
        $p->description = $r->description;
        $p->status = 1;
        $p->action_id = $action_id;

        DB::Begintransaction();
        try{
            if($p->save()){
                DB::commit();
                return response()->json($p,200);
            }
            else{
                DB::rollback();
                return response()->json('Error',500);
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json('Error general '.$e->getMessage(),500);
        }
    }

    // GET USER JSON BY EMAIL
    public function userByEmail(Request $r,$role){
        SofTeacher::ActionLog($r);
        
        $q = U::Where('email',$r->email)->where('fk_role',$role)->first();
        return response()->json($q,200);
    }
    

    //  GET ADDRESS JSON BY ZIPCODE
    public function zipcodeFilter(Request $r, $zipcode){
        SofTeacher::ActionLog($r);

        $q = ZC::Where('cp',$zipcode)->get();
        if($q->count() == 0)
            return response()->json(['error'=>'Error'],404);
        else
            return response()->json($q,200);
    }
}
