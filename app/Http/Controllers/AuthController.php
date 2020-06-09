<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\Users as U;

class AuthController extends Controller
{
    // Return View
    public function index(){
        return View('auth.login');
    }

    public function login(Request $r)
    {
        $credentials = ['email'=>$r->email,'password'=>$r->password,'status'=>1];

        $q = U::Where('email',$r->email);

        if($q->count()==1){
            $q=$q->first();
            if(Hash::check($r->password,$q->password)){
                if($q->status == 1){
                    if (Auth::attempt($credentials,$r->remember)) {
                        return redirect()->intended('dashboard');
                    }
                    else
                        return \Redirect::back()->withErrors(['danger','Error','Error al iniciar sesión, contacte al soporte técnico por favor']);
                }
                else
                    return \Redirect::back()->withErrors(['info','Información','El usuario se encuentra inactivo en esta plataforma']);
            }
                return \Redirect::back()->withErrors(['warning','Atención','La contraseña ingresada es incorrecta']);
        }
        else
            return \Redirect::back()->withErrors(['warning','Atención','Correo electrónico no registrado en esta plataforma']);
    }

    public function logout(){
        Auth::logout();
        return redirect('/auth/login');
    }
}
