<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Vanilo\Framework\Models\Taxon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Taxon::all();
        return view('pages.index', compact('categories'));
    }


}
