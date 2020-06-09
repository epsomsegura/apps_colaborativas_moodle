<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Libs
use App\Lib\SofTeacher;

// Models
use App\Models\Zipcodes as ZC;

class GlobalController extends Controller
{
    //
    public function zipcode_filter(Request $r, $zipcode){
        SofTeacher::ActionLog($r);

        $q = ZC::Where('cp',$zipcode)->get();
        if($q->count() == 0)
            return response()->json(['error'=>'Error'],404);
        else
            return response()->json($q,200);
    }
}
