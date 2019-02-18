<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Category\Models\Taxonomy;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('pages.admin.category');
    }

    public function create(Request $request){
        try{
        $category = Taxonomy::create(['name' => $request->name]);
            return response()->json([
                'message' => 'Successfully crceated category',
                'data' => $category
                ], 200);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create category'], 400);
        }
    }
}
