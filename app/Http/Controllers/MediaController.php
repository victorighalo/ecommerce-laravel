<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;

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
//                $imageName = time().'.'.request()->uploaded_file->getClientOriginalExtension();
                $ext = $request->file('uploaded_file')->clientExtension();
                $filename = preg_replace('/\..+$/', '', $request->file('uploaded_file')->getClientOriginalName());
                $extension =  $request->file('uploaded_file')->getClientOriginalExtension();
                $filename = strtolower($filename);

                try {
                    $newfilename = $filename. date('mds');

                    $path = $request->file('uploaded_file')->move(
                        'images/products/', $newfilename . '.' . $ext, 'public'
                    );

                    // Resize to upload smaller size
                    $image_resize = Image::make(public_path('/images/products/'.$newfilename . "." .$extension ));
//                    $height = $image_resize->height();
//                    $width = $image_resize->width();
//                    $size = $image_resize->filesize();
                    $image_resize->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image_resize->save(public_path('/images/products/'.$newfilename. "_thumb." .$extension ) );

                    $media = new Media();
                    $media->file = $newfilename;
                    $media->save();
                    return response()->json(['status' => 1, 'message' => 'Resource uploaded']);
                }
                catch(\Exception $e){
                    return response()->json(['status' => 0, 'message' => $e]);
                }
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
