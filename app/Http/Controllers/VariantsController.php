<?php

namespace App\Http\Controllers;

use App\ProductOption;
use App\ProductOptionsValue;
use Illuminate\Http\Request;
use Vanilo\Properties\Models\Property;
use Vanilo\Properties\Models\PropertyValue;

class VariantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $variants = ProductOption::all();
        return view('pages.admin.variants.index', compact('variants'));
    }

    public function indexJson(){
        $data = [];
        $variants = ProductOption::all();

        foreach ($variants as $item){
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'values' => $item->values(),
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function create(Request $request){
        try{
            $data = Property::ProductOption(['name' => $request->name, 'type' => $request->property_type]);
            return response()->json([
                'message' => 'Successfully created variant',
                'data' => $data
            ]);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create variant' . $e->getMessage()], 400);
        }
    }

    public function createVariantValue(Request $request){

        try{
            ProductOption::findBySlug($request->property_slug)->propertyValues()->create([
                'value' => $request->property_value
            ]);
            return response()->json([
                'message' => 'Success'
            ]);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create variant value' . $e->getMessage()], 400);
        }
    }

    public function getVariantsJson(){
        return response()->json(ProductOption::all());
    }

    public function update(Request $request){
        try{
            ProductOption::where('id', '=',$request->id)->update(['name' => $request->value]);
            return response()->json([
                'message' => 'Successfully updated variant'
            ]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create variant' . $e->getMessage()], 400);
        }
    }

    public function updateValue(Request $request){
        try{
            ProductOptionsValue::find($request->id)
                ->update([
                    'value' => $request->value
                ]);
            return response()->json([
                'message' => 'Successfully updated'
            ]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }


    public function destroyVariantVal($id){
        ProductOptionsValue::find($id)->delete();
        return response()->json([
            'message' => 'Successfully deleted'
        ]);
    }

    public function destroy($slug){
        ProductOption::findOneByName($slug)->delete();
        return response()->json([
            'message' => 'Successfully deleted'
        ]);
    }
}
