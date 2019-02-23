<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


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

        //Upload file
        if ($request->hasFile('uploaded_file')) {
            try {
                $path = 'images/'.date('Y').'/'.date('m');
                $upload_path = public_path($path);

                //Find or create upload folder
                if(!is_dir($upload_path)){
                    if(!mkdir($upload_path, 0777, true)){
                        return response()->json(['status' => 0, 'message' => 'An Error occurred. Try again.'], 400);
                    }
                }
                //Get file name
                $ext = $request->file('uploaded_file')->clientExtension();
                $filename = preg_replace('/\..+$/', '', $request->file('uploaded_file')->getClientOriginalName());
                $filename = strtolower($filename). '-' . date('mds');

                try {
                    //Upload raw file
                    $request->file('uploaded_file')->move(
                        $upload_path, $filename . '.' . $ext
                    );

                    // Resize to upload smaller size
                    $image_resize = Image::make($upload_path.'/'.$filename . "." .$ext );
                    $image_resize->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image_resize->save($upload_path.'/'.$filename. "_thumb." .$ext );

                    $media = new Media();
                    $media->file = $path.'/'.$filename. "_thumb.".$ext;
                    $media->save();
                    return response()->json(['status' => 1, 'message' => 'Resource uploaded']);
                }
                catch(\Exception $e){
                    return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
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

//    public function destroy(Request $request){
//        $media_item = Media::where('id', $request->mediaId);
//
//
//        try{
//            if(Storage::delete($media_item->file)){
//
//            }
//        }catch (\Exception $e){
//
//        }
//    }
}
