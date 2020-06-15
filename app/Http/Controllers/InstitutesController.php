<?php

namespace App\Http\Controllers;

// Packages
use Illuminate\Http\Request;

// Packages
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;

// Libs
use App\Lib\SofTeacher;

// Models
use App\Models\Institutes as I;
use App\Models\EducationLevels as EL;
use App\Models\Zipcodes as Z;

class InstitutesController extends Controller
{
    //
    public function index(Request $r){
        $data['institutes'] = I::with(['n_e'])->orderBy('name','ASC')->get();

        SofTeacher::ActionLog($r);
        return View('institutes.index', $data);
    }

    public function newInstitute(Request $r){
        $data['el'] = EL::orderBy('name','ASC')->get();

        SofTeacher::ActionLog($r);
        return View('institutes.create',$data);
    }

    public function saveInstitute(Request $r){
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            I::insert($data);
            DB::commit();
            return \Redirect::To('/institutes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }

    }

    public function editInstitute(Request $r,$id){
        $id = Crypt::decrypt($id);
        try{
            $data['i'] = I::findOrFail($id);
            $data['el'] = EL::orderBy('name','ASC')->get();
            $data['suburb'] = Z::Where('cp',$data['i']->zipcode)->get();
            return View('institutes.edit',$data);
        }
        catch(\Exception $e){
            return \Redirect::back()->withErrors(['danger','Error','El registro que busca no existe']);
        }
    }

    public function updateInstitute(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            I::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/institutes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteInstitute(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');

        DB::BeginTransaction();
        try{
            I::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/institutes');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }


    public function myInstitute(Request $r){
        SofTeacher::ActionLog($r);
        try{
            $data['i'] = I::With(['n_e'])->Where('id',Auth::user()->fk_institute)->first();
            $data['el'] = EL::orderBy('name','ASC')->get();
            $data['suburb'] = Z::Where('cp',$data['i']->zipcode)->get();
            return View('institutes.my_institute',$data);
        }
        catch(\Exception $e){
            return \Redirect::To('/home')->withErrors(['danger','Error','El registro que busca no existe']);
        }

    }
    
    public function saveMyInstitute(Request $r){
        SofTeacher::ActionLog($r);
        $action_id=SofTeacher::ActionLog($r);
        
        $data = $r->except('_token','_method');
        $data['action_id'] = $action_id;

        DB::BeginTransaction();
        try{
            I::Where('id',Auth::user()->fk_institute)->update($data);
            DB::commit();
            return \Redirect::To('/institutes/myInstitute');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }
}
