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

    public function create(Request $request){
        try{
            $data = Property::create(['name' => $request->name, 'type' => $request->property_type]);
            return response()->json([
                'message' => 'Successfully created property',
                'data' => $data
            ], 200);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function createPropertyValue(Request $request){
        try{
            $property = Property::findBySlug($request->property_slug);
            $property->propertyValues()->create([
                'title' => $request->property_title ? $request->property_title : '',
                'value' => $request->property_value
            ]);
            return response()->json([
                'message' => 'Successfully created property value',
                'data' => []
            ], 200);

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
                'message' => 'Successfully updated property',
                'data' => []
            ], 200);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function updateValue(Request $request){
        try{
            $model = PropertyValue::where('id', $request->id)
                ->update([
                    'title' => $request->value
                ]);
            return response()->json([
                'message' => 'Successfully updated property'
            ], 200);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }

    public function updateTitle(Request $request){
        try{
            $model = PropertyValue::where('id', $request->id)
                ->update([
                    'title' => $request->value
                ]);
            return response()->json([
                'message' => 'Successfully updated property'
            ], 200);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create property' . $e->getMessage()], 400);
        }
    }
}
