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
use \App\Models\Profiles as P;

class ProfilesController extends Controller
{
    //  Admin classes
    public function index(Request $r){
        $data['p'] = P::orderBy('profile','ASC')->get();
        
        return View('profiles.index',$data);
    }

    public function newProfile(Request $r){
        return View('profiles.create');
    }

    public function saveProfile(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::Begintransaction();
        try{
            P::insert($data);
            DB::commit();
            return \Redirect::to('/profiles');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }

    public function editProfile(Request $r,$id){
        $id=Crypt::decrypt($id);
        SofTeacher::ActionLog($r);

        $data['p'] = P::findOrFail($id);

        return View('profiles.edit',$data);
    }

    public function updateProfile(Request $r,$id){
        $id=Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::Begintransaction();
        try{
            P::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/profiles');
            
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteProfile(Request $r,$id){
        $id=Crypt::decrypt($id);
        SofTeacher::ActionLog($r);

        DB::Begintransaction();
        try{
            P::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/profiles');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }
}
