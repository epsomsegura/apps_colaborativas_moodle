<?php

namespace App\Http\Controllers;

// Packages
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

// Libs
use \App\Lib\SofTeacher;

// Models
use \App\Models\Institutes as I;
use \App\Models\Roles as R;
use \App\Models\StudentsExpedients as SE;
use \App\Models\TeachersExpedients as TE;
use \App\Models\Users as U;
use \App\Models\Zipcodes as ZC;

class UsersController extends Controller
{
    
    
    //Usuarios
    public function index(Request $r){
        $arr_roles = [];
        SofTeacher::ActionLog($r);

        switch(Auth::user()->fk_role){
            case 1: $arr_roles = [1,2,3,4,5]; break;
            case 2: $arr_roles = [3,4,5]; break;
        }
        
        if(Auth::user()->fk_institute == NULL)
            $data['u'] = U::With(['u_r'])->WhereIn('fk_role',$arr_roles)->Where('id','!=',Auth::user()->fk_role)->orderBy('name','ASC')->get();
        else
            $data['u'] = U::With(['u_r'])->WhereIn('fk_role',$arr_roles)->where('fk_institute',Auth::user()->fk_institute)->Where('id','!=',Auth::user()->fk_role)->orderBy('name','ASC')->get();
        
        return View('users.basic_data.index',$data);
    }

    public function newUser(Request $r){
        SofTeacher::ActionLog($r);
        switch(Auth::user()->fk_role){
            case 1: $arr_roles = [1,2,3,4,5]; break;
            case 2: $arr_roles = [2,3,4,5]; break;
        }
        
        $data['role'] = R::WhereIn('id',$arr_roles)->orderBy('role','ASC')->get();

        if(Auth::user()->fk_institute == NULL)
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();

        return View('users.basic_data.create',$data);
    }

    public function saveUser(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        if($r->password != $r->password2)
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas no coinciden']);

        $data = $r->except('_token','_method','password2');
        $data['action_id']=$action_id;
        $data['pasword']=Hash::make($r->password);

        DB::Begintransaction();
        try{
            U::insert($data);
            DB::commit();
            return \Redirect::To('/users');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }

    public function editUser(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        SofTeacher::ActionLog($r);

        switch(Auth::user()->fk_role){
            case 1: $arr_roles = [1,2,3,4,5]; break;
            case 2: $arr_roles = [2,3,4,5]; break;
        }

        $data['u'] = U::With(['u_i'])->where('id',$id)->first();
        
        $data['role'] = R::WhereIn('id',$arr_roles)->orderBy('role','ASC')->get();
        if(Auth::user()->fk_institute == NULL && $data['u']->fk_role != 4){
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();
            $data['idEst'] = ZC::where('cp',$data['u']->u_i->zipcode)->first()->idEstado;
            $data['m'] = ZC::groupBy('idMunicipio','municipio')->where('idEstado',$data['idEst'])->select('idMunicipio as id','municipio')->orderBy('municipio','ASC')->get();
            $data['idMun'] = ZC::where('cp',$data['u']->u_i->zipcode)->first()->idMunicipio; 
            $idMun = $data['idMun'];
            $data['ins'] = I::with(['zc_i'=>function($q) use ($idMun){
                $q->where('idMunicipio',$idMun)->get();
            }])->orderBy('name','ASC')->get();
        }

        return View('users.basic_data.edit',$data);
    }

    public function updateUser(Request $r, $id){
        $id = Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);

        if($r->password != $r->password2)
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas no coinciden']);

        $data = [];
        if($r->has('password')){
            $data = $r->except('_token','_method','password2');
            $data['password']=Hash::make($r->password);
        }
        else
            $data = $r->except('_token','_method','password','password2');

        $data['action_id']=$action_id;

        DB::Begintransaction();
        try{
            U::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/users');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function deleteUser(Request $r, $id){
        $id = Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);

        $data = $r->except('_token','_method');

        DB::BeginTransaction();
        try{
            U::Where('id',$id)->delete();
            DB::commit();
            return \Redirect::To('/users');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo eliminar el registro, contacte a soporte técnico']);
        }
    }

    public function softDeleteUser(Request $r, $id){
        $id = Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);

        $q = U::Where('id',$id)->first();
        $role = $q->fk_role;
        $status = $q->status;

        switch($role){
            case 3:
                TE::Where('fk_teacher',$id)->update(['status'=>(($status==1) ? 0: 1), 'action_id'=>$action_id]);
            break;
            case 5:
                SE::Where('fk_student',$id)->update(['status'=>(($status==1) ? 0: 1), 'action_id'=>$action_id]);
            break;
        }

        U::Where('id',$id)->update(['status'=>(($status==1) ? 0: 1), 'action_id'=>$action_id]);

        return \Redirect::To('/users');
    }





    // Mi perfil
    public function myProfile(Request $r){
        $data['u'] = U::find(Auth::user()->id);

        return View('users.myProfile',$data);
    }

    public function saveMyProfile(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        if($r->password != $r->password2)
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas no coinciden']);

        $data = [];
        if($r->has('password')){
            $data['password']=Hash::make($r->password);
            $data = $r->except('_token','_method','password2');
        }
        else
            $data = $r->except('_token','_method','password','password2');

        $data['action_id']=$action_id;

        DB::Begintransaction();
        try{
            U::Where('id',Auth::user()->id)->update($data);
            DB::commit();
            Auth::logout();
            return redirect('/auth/login');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::To('/home')->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

 



    // STUDENTS
    public function getStudents(Request $r){
        $data['st']=[];
        $q = SE::With(['se_stud','se_prnt','se_inst']);
        
        if(Auth::user()->fk_role == 1)
            $data['st'] = $q->get();
        elseif(Auth::user()->fk_role == 2)
            $data['st'] = $q->where('fk_institute',Auth::user()->fk_institute)->get();
        
        return View('users.students.index',$data);
    }

    public function newStudentData(Request $r){
        SofTeacher::ActionLog($r);
        $data=[];
        if(Auth::user()->fk_institute == NULL)
            $data['states'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->get();
        else{
            $q = I::findOrFail(Auth::user()->fk_institute);
            $data['institute'] = $q;
            $data['groups'] = SofTeacher::groupLetter($q->groups);
        }

        return View('users.students.create',$data);
    }
      
    public function saveStudentData(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $r->except('_token','_method');
        
        if($r->password[0] != $r->password2[0])
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del estudiante no coinciden']);
        
        if($r->password[1] != $r->password2[1])
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del padre/tutor no coinciden']);
        
        $obj_student=['name'=>$r->name[0],'email'=>$r->email[0],'password'=>Hash::make($r->password[0]),'fk_role'=>5]; 
        $obj_parent=['name'=>$r->name[1],'email'=>$r->email[1],'password'=>Hash::make($r->password[1]),'fk_role'=>4];

        DB::Begintransaction();
        try{
            $id_student = U::create($obj_student)->id;
            $id_parent = (U::Where('email',$obj_parent['email'])->count()==0) ? U::create($obj_parent)->id : U::Where('email',$obj_parent['email'])->first()->id;
            $objExpedient = [
                'fk_student' => $id_student,
                'fk_parent' => $id_parent,
                'fk_institute' => $r->fk_institute,
                'shift' => $r->shift,
                'grade' => $r->grade,
                'group_class' => $r->group_class,
                'action_id' => $action_id
            ];

            SE::insert($objExpedient);

            DB::commit();
            return \Redirect::To('/users/students');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }
    }
       
    public function editStudentData(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        SofTeacher::ActionLog($r);

        switch(Auth::user()->fk_role){
            case 1: $arr_roles = [1,2,3,4,5]; break;
            case 2: $arr_roles = [2,3,4,5]; break;
        }

        $data['u'] = SE::With(['se_stud','se_prnt','se_inst'])->where('id',$id)->first();        
        $data['role'] = R::WhereIn('id',$arr_roles)->orderBy('role','ASC')->get();

        if(Auth::user()->fk_institute == NULL){
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();
            $data['idEst'] = ZC::where('cp',$data['u']->se_inst->zipcode)->first()->idEstado;
            $data['m'] = ZC::groupBy('idMunicipio','municipio')->where('idEstado',$data['idEst'])->select('idMunicipio as id','municipio')->orderBy('municipio','ASC')->get();
            $data['idMun'] = ZC::where('cp',$data['u']->se_inst->zipcode)->first()->idMunicipio; 
            $idMun = $data['idMun'];
            $data['ins'] = I::with(['zc_i'=>function($q) use ($idMun){
                $q->where('idMunicipio',$idMun)->get();
            }])->orderBy('name','ASC')->get();
        }
        else{            
            $q = I::findOrFail(Auth::user()->fk_institute);
            $data['ins'] = Auth::user()->fk_institute;
            $data['institute'] = $q;
            $data['groups'] = SofTeacher::groupLetter($q->groups);
        }
     
        return View('users.students.edit',$data);
    }

    public function updateStudentData(Request $r, $id){            
        $id = Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);
        $q = SE::find($id);
        
        $r->except('_token','_method');
        
        $obj_student=['name'=>$r->name[0],'status'=>1,'updated_at'=>Carbon::now(),'action_id'=>$action_id]; 
        $obj_parent=['name'=>$r->name[1],'status'=>1,'updated_at'=>Carbon::now(),'action_id'=>$action_id];
        
        if(U::find($q->fk_student)->email != $r->email[0])
            $obj_student['email']=$r->email[0];
        if(U::find($q->fk_parent)->email != $r->email[1])
            $obj_parent['email']=$r->email[1];
        
        if($r->has('password')){
            if($r->password[0] != $r->password2[0])
                return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del estudiante no coinciden']);
            else
                $obj_student['password'] = Hash::make($r->password[0]);
        

            if($r->password[1] != $r->password2[1])
                return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del padre/tutor no coinciden']);
            else
                $obj_parent['password'] = Hash::make($r->password[1]);
        }

        DB::Begintransaction();
        try{
            U::Where('id',$q->fk_student)->update($obj_student);
            U::Where('id',$q->fk_parent)->update($obj_student);

            $data=[
            'fk_institute' => $r->fk_institute,
            'shift' => $r->shift,
            'grade' => $r->grade,
            'group_class' => $r->group_class,
            'status' => 1,
            'updated_at' => Carbon::now(),
            'action_id' => $action_id
            ];

            SE::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/users/students');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }

    public function softDeleteStudent(Request $r, $id){
        $id = Crypt::decrypt($id);

        $action_id = SofTeacher::ActionLog($r);
        $se = SE::Where('id',$id);
        $s = U::Where('id',SE::Where('id',$id)->first()->fk_student);

        if($se->first()->status == 1)
            $se->update(['status'=>0,'action_id'=>$action_id]);
        else
            $se->update(['status'=>1,'action_id'=>$action_id]);

        
        if($s->first()->status == 1)
            $s->update(['status'=>0,'action_id'=>$action_id]);
        else
            $s->update(['status'=>1,'action_id'=>$action_id]);

        return \Redirect::To('/users/students');
    }






    // Teachers
    public function getTeachers(Request $r){
        $data['tc']=[];
        $q = TE::With(['te_teach','te_inst','te_prof']);
        
        if(Auth::user()->fk_role == 1)
            $data['tc'] = $q->get();
        elseif(Auth::user()->fk_role == 2)
            $data['tc'] = $q->where('fk_institute',Auth::user()->fk_institute)->get();
        
        return View('users.teachers.index',$data);
    }

    public function newTeacherData(Request $r){
        SofTeacher::ActionLog($r);
        $data=[];
        if(Auth::user()->fk_institute == NULL)
            $data['states'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->get();
        else{
            $q = I::findOrFail(Auth::user()->fk_institute);
            $data['institute'] = $q;
        }

        return View('users.teachers.create',$data);
    }

    public function saveTeacherData(Request $r){
        $action_id = SofTeacher::ActionLog($r);

        $r->except('_token','_method');

        if($r->password[0] != $r->password2[0])
            return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del estudiante no coinciden']);
        
        $obj_teacher=['name'=>$r->name[0],'email'=>$r->email[0],'fk_role'=>5]; 
        
        if($r->has('password'))
            if($r->password!='')
                $obj_teacher['password']=Hash::make($r->password[0]);

        DB::Begintransaction();
        try{
            $id_teacher = (U::Where('email',$r->email)->count()==0) ? U::create($obj_teacher)->id : U::Where('email',$r->email)->first()->id;
            if(TE::Where('fk_teacher',$id_teacher)->where('fk_institute',$r->fk_institute)->count()==0){
                $objExpedient = [
                    'fk_teacher' => $id_teacher,
                    'fk_institute' => $r->fk_institute,
                    'fk_profile' => $r->fk_profile,
                    'status' => 1,
                    'action_id' => $action_id
                ];
                TE::insert($objExpedient);
            }
            else{
                $objExpedient = [
                    'fk_teacher' => $id_teacher,
                    'fk_institute' => $r->fk_institute,
                    'fk_profile' => TE::Where('fk_teacher',$id_teacher)->first()->fk_profile,
                    'status' => 1,
                    'action_id' => $action_id
                ];
                TE::Where('fk_teacher',$id_teacher)->where('fk_institute',$r->fk_institute)->update($objExpedient);
            }

            DB::commit();
            return \Redirect::To('/users/teachers');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo guardar el registro, contacte a soporte técnico']);
        }

    }

    public function editTeacherData(Request $r, $id){
        $id = Crypt::decrypt($id);
        
        SofTeacher::ActionLog($r);

        switch(Auth::user()->fk_role){
            case 1: $arr_roles = [1,2,3,4,5]; break;
            case 2: $arr_roles = [2,3,4,5]; break;
        }

        $data['u'] = TE::With(['te_teach','te_prof','te_inst'])->where('id',$id)->first();        

        if(Auth::user()->fk_institute == NULL){
            $data['s'] = ZC::groupBy('idEstado','estado')->select('idEstado as id','estado as estado')->orderBy('estado','ASC')->get();
            $data['idEst'] = ZC::where('cp',$data['u']->te_inst->zipcode)->first()->idEstado;
            $data['m'] = ZC::groupBy('idMunicipio','municipio')->where('idEstado',$data['idEst'])->select('idMunicipio as id','municipio')->orderBy('municipio','ASC')->get();
            $data['idMun'] = ZC::where('cp',$data['u']->te_inst->zipcode)->first()->idMunicipio; 
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

        
        return View('users.teachers.edit',$data);
    }

    public function updateTeacherData(Request $r, $id){            
        $id = Crypt::decrypt($id);
        $action_id = SofTeacher::ActionLog($r);
        $q = TE::find($id);
        
        $r->except('_token','_method');
        
        $obj_teacher=['name'=>$r->name[0],'status'=>1,'updated_at'=>Carbon::now(),'action_id'=>$action_id]; 
        
        if(U::find($q->fk_teacher)->email != $r->email[0])
            $obj_teacher['email']=$r->email[0];
        
        if($r->has('password')){
            if($r->password[0] != $r->password2[0])
                return \Redirect::back()->withErrors(['danger','Error','Las contraseñas del estudiante no coinciden']);
            else
                $obj_teacher['password'] = $r->password[0];
        }

        DB::Begintransaction();
        try{
            U::Where('id',$q->fk_teacher)->update($obj_teacher);

            $data=[
            'fk_institute' => $r->fk_institute,
            'fk_profile' => $r->fk_profile,
            'status' => 1,
            'updated_at' => Carbon::now(),
            'action_id' => $action_id
            ];

            TE::Where('id',$id)->update($data);
            DB::commit();
            return \Redirect::To('/users/teachers');
        }
        catch(\Exception $e){
            DB::rollback();
            return \Redirect::back()->withErrors(['danger','Error','No se pudo actualizar el registro, contacte a soporte técnico']);
        }
    }
}
