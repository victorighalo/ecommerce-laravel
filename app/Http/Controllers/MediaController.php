<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
                $path2 = date('Y').'/'.date('m');
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
//                    $image_resize = Image::make($upload_path.'/'.$filename . "." .$ext );
//                    $image_resize->resize(200, null, function ($constraint) {
//                        $constraint->aspectRatio();
//                    });
//                    $image_resize->save($upload_path.'/'.$filename. "_thumb." .$ext );

                    $media = new Media();
                    $media->file = $path.'/'.$filename. ".".$ext;
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
        $sliders = Media::latest()->limit(40)->get();
        return $sliders;
    }

    public function destroy(Request $request){
        $media_item = Media::where('id', $request->mediaId)->first();
        try{
            $path_file = public_path('/'.$media_item->file);
            $file_exists =  File::exists($media_item->file);
            if(File::delete($path_file)){
                $media_item->delete();
                return response()->json(['status' => 200, 'message' => 'Media deleted'], 200);
            }else{
                $media_item->delete();
                return response()->json(['status' => 200, 'message' => 'Corrupt media deleted '.$file_exists . $path_file], 200);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media'], 400);
        }
    }

    public function destroySpatieMedia(Request $request){
        try{
            \Spatie\MediaLibrary\Models\Media::where('id', $request->id)->delete();
            return response()->json(['status' => 200, 'message' => 'Media deleted'], 200);
        }catch (\Exception $e){
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media'], 400);
        }
    }
}
