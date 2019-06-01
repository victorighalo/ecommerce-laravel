<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function loadCities(Request $request){
        return response()->json(DB::table('cities')->where('state_id', $request->id)->get());
    }

    public function addAddress(Request $request){

    }

    public function contact(){
        return view('pages.front.contact');
    }

    public function about(){
        return view('pages.front.about');
    }

    public function sendEmail(){

    }

    public function updateProfile(ProfileUpdateRequest $request){
        $validated = $request->validated();
        Auth::user()->fill($validated)->save();
        return back()->with('status', 'Profile updated');
    }

    public function changePassword(ChangePasswordRequest $request){
        Auth::user()->update([
            'password' => bcrypt(request('password'))
        ]);
        return back()->with('status', 'Password updated');
    }
}
