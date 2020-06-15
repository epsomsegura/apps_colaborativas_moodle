<?php
namespace App\Lib;

// Libraries
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

// Models
use App\Models\Actions as A;

class SofTeacher{
    /**
    * Obtener IP
    * Retorna la IP del cliente
    * @access private
    * @return String Retorna la IP del cliente
    */
    private static function get_ip(){
        $ip = NULL;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }

    /**
    * Nombre de la acción
    * @access private
    * @param String $m_name - Nombre del método HTTP de la petición
    * @return String Retorna una clasificación de la acción ejecutada dependiendo del método HTTP
    */
    private static function action_name($m_name){
        $name = NULL;
        switch($m_name){
            case 'POST': $name = "Crear"; break;
            case 'PUT': case 'PATCH': $name = "Actualuzar"; break;
            case 'DELETE': $name = "Eliminar"; break;
            default: break;
        }

        return $name;
    }




    /**
    * Se encarga de almacenar los logs de cada operación dentro del sistema
    * Logs de acceso por usuario en la plataforma
    * @access  public
    * @param Request $r - Petición completa solicitada por el cliente
    * @return int ID del registro
    */
    public static function ActionLog($r){
        DB::BeginTransaction();
        try{
            if($r->method() != 'GET'){
                $a = new A();
                $a->fk_user = Auth::user()->id;
                $a->action_ip = self::get_ip();
                $a->action_date = Carbon::now();
                $a->action_name = self::action_name($r->method());
                $a->action_method = $r->method();
                $a->action_path = '/'.$r->path();
                $a->action_params = json_encode($r->except('_token','_method'));
        
                $a->save();
                DB::commit();
                return $a->id;
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return "Error: ".$e->getMessage();
        }
    }

    /**
    * Se encarga de retornar las letras de los grupos de un instituto
    * @access  public
    * @param int $groups - Número de grupos por grado
    * @return int $groups - Retorna las letras correspondientes a la cantidad de grupos de una institución
    */
    public static function groupLetter($groups){
        $alphabet = range('A', 'Z');
        $groups = array_slice($alphabet,0,$groups);
        return $groups;
    }

    /**
    * Se encarga de retornar las letras de los grupos de un instituto
    * @access  public
    * @param int $pos - Número del grupo
    * @return String $letter - Letra asignada al número del grupo
    */
    public static function getGroupLetter($pos){
        $alphabet = range('A', 'Z');
        $letter = $alphabet[$pos-1];
        return $letter;
    }
}