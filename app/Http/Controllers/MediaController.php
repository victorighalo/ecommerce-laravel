<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function UploadMedia(Request $request){
        // Validate input
        $validator = Validator::make($request->all(), [
            'uploaded_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            response()->json(['message' => "Validation failed"], 400);
        }

        if ($request->hasFile('uploaded_file')) {
            try {
                $imageName = time().'.'.request()->uploaded_file->getClientOriginalExtension();
                request()->uploaded_file->move(public_path('images/products'), $imageName);

                Media::create([
                    'file' => 'images/products/'.$imageName
                ]);
                return response()->json(['status' => 1, 'message' => 'Resource uploaded']);
            }
            catch(\Exception $e){
                return response()->json(['status' => 0, 'message' => $e->getMessage()]);
            }
        }
        else{
            return response()->json(['status' => 0, 'message' => 'An Error occurred']);
        }
    }

    public function loadImages(){
        $sliders = Media::latest()->limit(20)->get();
        return $sliders;
    }
}
