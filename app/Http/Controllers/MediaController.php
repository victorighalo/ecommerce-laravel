<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoUploadRequest;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class MediaController extends Controller
{

    public function uploadMedia(Request $request){
        if(config('app.PHOTO_DRIVER') == 'local'){
            return $this->uploadLocal($request);
        }elseif (config('app.PHOTO_DRIVER') == 's3'){
            return $this->uploadToS3($request);
        }
    }

    public function destroyMedia(Request $request){
        if(config('app.PHOTO_DRIVER') == 'local'){
            return $this->destroyLocal($request);
        }elseif (config('app.PHOTO_DRIVER') == 's3'){
            return $this->destroyS3($request);
        }
    }

    private function uploadLocal(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'uploaded_file' => 'required|image|max:400'
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
                    return response()->json(['status' => 0, 'message' => 'An Error occurred creating images part. Try again.'], 400);
                }
            }

            if (!is_dir($thumb_upload_path)) {
                if (!mkdir($thumb_upload_path, 0777, true)) {
                    return response()->json(['status' => 0, 'message' => 'An Error occurred craeting thumnail path. Try again.'], 400);
                }
            }
            //Get file name
            $ext = $request->file('uploaded_file')->clientExtension();
//                $filename = preg_replace('/\..+$/', '', $request->file('uploaded_file')->getClientOriginalName());
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

                $media = new Media();
                $media->file = $path . '/' . $filename . "." . $ext;
                $media->driver = 'local';
                $media->save();
                return response()->json(['status' => 1, 'message' => 'Resource uploaded']);
            } catch (\Exception $e) {
                return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    private function uploadToS3(Request $request){
        // Validate input
        $validator = Validator::make($request->all(), [
            'uploaded_file' => 'required|image|max:400'
        ]);

        if ($validator->fails()) {
            response()->json(['message' => "Validation failed"], 400);
        }

        try {
            $image = $request->file('uploaded_file');
            $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            $path = 'images/';
            $thumb_path = 'images/thumbnail/';

            $file_ext = $request->file('uploaded_file')->clientExtension();
            $file_name = md5(uniqid());



            // Resize to upload smaller size
            $image_resize = Image::make($image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                });

            $resource = $image_resize->stream()->detach();

            $full_file_name = $file_name . '.' . $file_ext;
            $file_path = $path . $full_file_name;
            $file_path_thumb = $thumb_path . $full_file_name;

            //AWS UPLOAD
            Storage::disk('s3')->put($file_path, file_get_contents($image), 'public');

            //Upload thumb
            Storage::disk('s3')->put($file_path_thumb, $resource, 'public');

            //Record uploaded image
            $media = new Media();
            $media->file = $full_file_name;
            $media->driver = 's3';
            $media->save();

            return response()->json(['status' => 1, 'message' => 'Resource uploaded']);
        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function loadImages()
    {
        if(config('app.PHOTO_DRIVER') == 'local') {
            $photos = Media::where('driver', 'local')->latest()->limit(40)->get();
            $data = [];
            foreach ($photos as $item) {
                $data[] = (object)[
                    'id' => $item->id,
                    'file' => $item->file,
                    'thumb' => 'thumbnail/' . $item->file,
                    'created_at' => $item->created_at
                ];
            }
            return $data;
        }else if( config('app.PHOTO_DRIVER') == 's3' ){
            $photos = Media::where('driver', 's3')->latest()->limit(40)->get();
            $data = [];
            foreach ($photos as $item) {
                $data[] = (object)[
                    'id' => $item->id,
                    'file' => $item->file,
                    'thumb' => 'thumbnail/' . $item->file,
                    'created_at' => $item->created_at
                ];
            }
            return $data;
         }
    }

    private function destroyLocal(Request $request)
    {
        if(!Media::where('id', $request->mediaId)->exists()){
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media. File does not exist'], 400);
        }

        $media_item = Media::where('id', $request->mediaId);
        $file = $media_item->first()->file;

        try {
            $path_file = public_path('/' . $file);
            $thumb_path_file = public_path('thumbnail/' . $file);

            if (File::exists($file)) {
                File::delete($path_file);
            }

            if (File::exists('thumbnail/' . $file)) {
                File::delete($thumb_path_file);
            }
            $media_item->delete();
            return response()->json(['status' => 200, 'message' => 'Media deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media'], 400);
        }
    }

    private function destroyS3(Request $request)
    {
        if(!Media::where('id', $request->mediaId)->exists()){
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media. File does not exist'], 400);
        }

        $media_item = Media::where('id', $request->mediaId);
        $file = $media_item->first()->file;
        try {
            if (Storage::disk('s3')->exists('images/'.$file)) {
                //DELETE PHOTO
                Storage::disk('s3')->delete('images/'.$file);
            }
            if (Storage::disk('s3')->exists('images/thumbnail/'.$file)) {
                //DELETE THUMB
                Storage::disk('s3')->delete('images/thumbnail/'.$file);
            }
            $media_item->delete();
            return response()->json(['status' => 200, 'message' => 'Media deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media '.$e->getMessage()], 400);
        }
    }

    public function destroySpatieMedia(Request $request)
    {
        try {
            \Spatie\MediaLibrary\Models\Media::where('id', $request->id)->delete();
            return response()->json(['status' => 200, 'message' => 'Media deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to delete Media'], 400);
        }
    }


}
