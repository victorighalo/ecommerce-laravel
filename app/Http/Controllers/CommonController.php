<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function loadCities(Request $request){
        return response()->json(DB::table('cities')->where('state_id', $request->id)->get());
    }

    public function addAddress(Request $request){

    }
}
