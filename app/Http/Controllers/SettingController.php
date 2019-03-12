<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = \App\Setting::get();
        return view('pages.admin.settings', compact('setting'));
    }
}
