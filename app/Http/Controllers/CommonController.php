<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;

use App\Mail\AmazonSes;
use App\Mail\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function productRequest(Request $request){
        $status = Mail::to($request->input('email'))->send(new ProductRequest($request->input('product'),$request->input('message'),$request->input('email')));
        return response()->json(['message'=>'Message sent','status'=>$status]);
    }
}
