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
use App\Models\Roles as R;

class RolesController extends Controller
{
    //
    public function index(Request $r){
        $data['role'] = R::orderBy('role','ASC')->get();

        SofTeacher::ActionLog($r);
        return View('roles.index', $data);
    }
    
    public function newRole(Request $r){
        SofTeacher::ActionLog($r);
        return View('roles.create');
    }

    public function saveRole(Request $r){
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            R::insert($data);
            DB::commit();
            return \Redirect::To('/roles');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }

    public function editRole(Request $r,$id){
        $id = Crypt::decrypt($id);
        try{
            $data['r'] = R::findOrFail($id);
            return View('roles.edit',$data);
        }
        catch(\Exception $e){
            return \Redirect::back()->withErrors(['danger','Error','El registro que busca no existe']);
        }
    }

    public function updateRole(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            R::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/roles');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteRole(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        SofTeacher::ActionLog($r);
        
        DB::BeginTransaction();
        try{
            R::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/roles');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }
}
