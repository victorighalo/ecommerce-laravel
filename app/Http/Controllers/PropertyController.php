<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Properties\Models\Property;
use Vanilo\Properties\Models\PropertyValue;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $properties = Property::all();
        return view('pages.admin.property.index', compact('properties'));
    }

    public function indexJson(){
        $data = [];
        $properties = Property::all();

        foreach ($properties as $item){
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
            $data = Property::create(['name' => $request->name, 'type' => $request->property_type]);
            return response()->json([
                'message' => 'Successfully created property',
                'data' => $data
            ]);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function createPropertyValue(Request $request){

        try{
            Property::findBySlug($request->property_slug)->propertyValues()->create([
                'value' => $request->property_value,
                'title' => $request->property_title ? $request->property_title : ' '
            ]);
            return response()->json([
                'message' => 'Successfully created property value'
            ]);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function getPropertiesJson(){
        return response()->json(Property::all());
    }

    public function update(Request $request){
        try{
            Property::findBySlug($request->id)->update(['name' => $request->value]);
            return response()->json([
                'message' => 'Successfully updated property'
            ]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function updateValue(Request $request){
        try{
            PropertyValue::where('id', $request->id)
                ->update([
                    'title' => $request->value
                ]);
            return response()->json([
                'message' => 'Successfully updated property'
            ]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function updateTitle(Request $request){
        try{
            PropertyValue::where('id', $request->id)
                ->update([
                    'title' => $request->value
                ]);
            return response()->json([
                'message' => 'Successfully updated property'
            ]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function destroyPropVal($id){
        PropertyValue::where('id', $id)->delete();
        return response()->json([
            'message' => 'Successfully deleted Property Value'
        ]);
    }

    public function destroy($slug){
        Property::findOneByName($slug)->delete();
        return response()->json([
            'message' => 'Successfully deleted Property'
        ]);
    }
}
