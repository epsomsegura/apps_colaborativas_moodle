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

class ClassesController extends Controller
{
    //  Admin classes
    public function index(Request $r){
        $data['c'] = C::orderBy('classname','ASC')->get();
        
        return View('classes.index',$data);
    }

    public function newClass(Request $r){
        return View('classes.create');
    }

    public function saveClass(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::Begintransaction();
        try{
            C::insert($data);
            DB::commit();
            return \Redirect::to('/classes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }

    public function editClass(Request $r,$id){
        $id=Crypt::decrypt($id);
        SofTeacher::ActionLog($r);

        $data['c'] = C::findOrFail($id);

        return View('classes.edit',$data);
    }

    public function updateClass(Request $r,$id){
        $id=Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::Begintransaction();
        try{
            C::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/classes');
            
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteClass(Request $r,$id){
        $id=Crypt::decrypt($id);
        SofTeacher::ActionLog($r);

        DB::Begintransaction();
        try{
            C::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/classes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }
}
