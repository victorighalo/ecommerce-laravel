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
        $categories = $this->taxonomiesWithChildren(1);
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

    protected function taxonomiesWithChildren($taxonomy_id){
        $categories = Taxonomy::all();
        $menu = [];
        foreach ($categories as $category){
        $menu[] = (object)[
            'taxonomy_id' => $category->id,
            'taxonomy_name' => $category->name,
            'taxonomy_slug' => $category->slug,
            'taxons' => $this->getTaxons($category->id)->toArray()
            ];
        }
        return $menu;
    }

    protected function getTaxons($taxonomy_id){
        return Taxon::byTaxonomy($taxonomy_id)->get();
    }
}
