<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Vanilo\Category\Models\Taxonomy;
use Vanilo\Category\Models\Taxon;
use Vanilo\Product\Models\Product;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getTaxons($taxonomy_id){
        return Taxon::byTaxonomy($taxonomy_id)->get();
    }

    public function getTaxonomiesJson(){
        return response()->json(Taxonomy::all());
    }

    public function index(){
        $categories = Taxonomy::all();
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
            $taxonomy = Taxonomy::where('id', $request->category_id)->first();
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

    public function createChildCategory(Request $request){
        $request->validate([
            'taxonomy_id' => 'required',
            'taxon_id' => 'required',
            'input' => 'required',
        ]);

        try{
        Taxon::create([
            'taxonomy_id' => $request->taxonomy_id,
            'parent_id' => $request->taxon_id,
            'name' => $request->input
        ]);
            return response()->json([
                'message' => 'Successfully crceated Child Category'
            ], 200);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create category' . $e->getMessage()], 400);
        }
    }

    protected function taxonomiesWithChildren(){
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

    public function destroyTaxon($id){
        try{
        Taxon::where('id', $id)->delete();
        return response()->json(['message' => 'Deleted', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Delete', 'status' => 400], 400);
        }
    }

    public function destroyTaxonomy($id){
        try{
            Taxonomy::where('id', $id)->delete();
            return response()->json(['message' => 'Deleted', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Delete', 'status' => 400], 400);
        }
    }

    public function editTaxon(Request $request){
        try{
            $taxonomy = Taxonomy::where('id', $request->category_id)->first();
            $taxon = Taxon::where('id', $request->id)->first();
            $taxon->name = $request->value;
            $taxon->slug = Str::slug(strtolower($request->value.'-'.$taxonomy->slug));
            $taxon->save();
            return response()->json(['message' => 'Subcategory Updated', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Update' . $e->getMessage(), 'status' => 400], 400);
        }
    }

    public function editTaxonomy(Request $request){
        try{
            $taxonomy = Taxonomy::where('id', $request->id)->first();
            $taxonomy->name = $request->value;
            $taxonomy->save();
            return response()->json(['message' => 'Category Updated', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Update' . $e->getMessage(), 'status' => 400], 400);
        }
    }

    public function addTaxonImage(Request $request)
    {

        // Validate input
        $validator = Validator::make($request->all(), [
            'uploaded_file' => 'required|image|max:400',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            response()->json(['message' => "Validation failed"], 400);
        }

        try {
            $path = 'images/' . date('Y') . '/' . date('m');
            $thumb_path = 'thumbnail/images/' . date('Y') . '/' . date('m');
            $upload_path = public_path($path);
            $thumb_upload_path = public_path($thumb_path);

            //Find or create upload folder
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0777, true)) {
                    return response()->json(['status' => 0, 'message' => 'An Error occurred creating images path. Try again.'], 400);
                }
            }

            if (!is_dir($thumb_upload_path)) {
                if (!mkdir($thumb_upload_path, 0777, true)) {
                    return response()->json(['status' => 0, 'message' => 'An Error occurred craeting thumnail path. Try again.'], 400);
                }
            }

            //Get file name
            $ext = $request->file('uploaded_file')->clientExtension();

            $filename = md5(uniqid());

            try {

                //Upload raw file
                $request->file('uploaded_file')->move(
                    $upload_path, $filename . '.' . $ext
                );


                // Resize to upload smaller size
                $image_resize = Image::make($upload_path . '/' . $filename . "." . $ext)
                    ->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $image_resize->save($thumb_upload_path . '/' . $filename . "." . $ext);


                Taxonomy::where('id', $request->category_id)->update([
                        'image' => $path . '/' . $filename . "." . $ext
                ]);

                return response()->json(['status' => 1, 'message' => 'Image Uploaded']);
            } catch (\Exception $e) {
                return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }
}
