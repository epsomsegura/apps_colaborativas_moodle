<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Packages
use DB;
use Auth;
use Illuminate\Support\Facades\Crypt;

// Libs
use App\Lib\SofTeacher;

// Models
use App\Models\EducationLevels as EL;

class EducationLevelsController extends Controller
{
    //
    public function index(Request $r){
        $data['el'] = EL::orderBy('name','ASC')->get();

        SofTeacher::ActionLog($r);
        return View('education_level.index', $data);
    }
    
    public function newEducationLevel(Request $r){
        SofTeacher::ActionLog($r);
        return View('education_level.create');
    }

    public function saveEducationLevel(Request $r){
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            EL::insert($data);
            DB::commit();
            return \Redirect::To('/education_level');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }

    public function editEducationLevel(Request $r,$id){
        $id = Crypt::decrypt($id);
        try{
            $data['el'] = EL::findOrFail($id);
            return View('education_level.edit',$data);
        }
        catch(\Exception $e){
            return \Redirect::back()->withErrors(['danger','Error','El registro que busca no existe']);
        }
    }

    public function updateEducationLevel(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            EL::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/education_level');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteEducationLevel(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        SofTeacher::ActionLog($r);
        
        DB::BeginTransaction();
        try{
            EL::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/education_level');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }
}
