<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = \App\Setting::get();
        return view('pages.admin.settings', compact('setting'));
    }

    public function store(Request $request){

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

    public function update(Request $request){

        try {
            $setting = \App\Setting::find(1);
            $setting->store_name = $request->store_name;
            $setting->store_description = $request->store_description;
            $setting->store_address = $request->store_address;
            $setting->store_email = $request->store_email;
            $setting->store_phone = $request->store_phone;
            $setting->store_about = $request->store_about;
            $setting->store_twitter = $request->store_twitter;
            $setting->store_facebook = $request->store_facebook;
            $setting->store_instagram = $request->store_instagram;
            $setting->store_linkedin = $request->store_linkedin;
            $setting->store_youtube = $request->store_youtube;
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
