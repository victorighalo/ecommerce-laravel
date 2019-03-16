<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = \App\Setting::get();
        return view('pages.admin.settings', compact('setting'));
    }

    public function update(Request $request){

        try {
            $setting = new \App\Setting();
            if($setting->exists()){
                return back()->with('status', 'App already installed');
            }
            $setting->store_name = $request->store_name;
            $setting->store_description = $request->store_description;
            $setting->store_address = $request->store_address;
            $setting->store_email = $request->store_email;
            $setting->store_phone = $request->store_phone;
            $setting->store_about = $request->store_about;
            $setting->save();
            return back()->with('status', 'Settings updated');
        }catch (\Exception $e){
            return back()->with('error', 'Failed to update settings'. $e->getMessage());
        }
    }

    public function install(){
        return view('pages.install');
    }
}
