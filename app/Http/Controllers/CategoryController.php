<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Category\Models\Taxonomy;
use Vanilo\Category\Models\Taxon;
use Vanilo\Product\Models\Product;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $categories = Taxonomy::all();
        dd($categories);
        return view('pages.admin.category', compact('categories'));
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


    public function createSubCategory(Request $request){
        try{
            $category = Taxon::create([
                'taxonomy_id' => $request->category_id,
                'name' => $request->sub_category
            ]);
            return response()->json([
                'message' => 'Successfully crceated category',
                'data' => $category
                ], 200);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create category' . $e->getMessage()], 400);
        }
    }
}
