<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;

// Libs
use \App\Lib\SofTeacher;

// Models
use \App\Models\Zipcodes as ZC;
use \App\Models\Institutes as I;


class GradesGroupsController extends Controller
{
    //
    public function index(Request $r){
        SofTeacher::ActionLog($r);

        if(Auth::user()->fk_role == 1)
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();
        else
            $data['id'] = Auth::user()->fk_institute;

        return View('grades_groups.index',$data);
    }

    public function instituteData(Request $r, $id){
        $q = I::findOrFail($id);

        return response()->json($q,200);
    }

    public function saveInstituteData(Request $r,$id){
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::Begintransaction();
        try{
            I::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/grades-groups');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }
}
