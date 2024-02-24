<?php

namespace App\Libraries;

// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;

use App\Logging\CustomFile;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Image;
use Throwable;
use Intervention\Image\Facades\Image;

class ImageLibrary {
    public static function createBase64Image($image, $fileSize, $resize = ['width' => 150, 'height' => 150]){
        $name = "";

        if($image->getSize() <= $fileSize) {
            $mime_type = $image->getMimeType() ? $image->getMimeType() : 'image/png';
            $name = 'data:' . $mime_type . ';base64,' . base64_encode(file_get_contents($image));
        }
        return $name;
    }

    public function createImage($image,int $width = 400,int $height = 300, $filepath){
        // create custom folder with user id if doesn't exist yet
        if(!File::exists($filepath)){
            Storage::disk('public')->makeDirectory($filepath);
        }

        // image resize logic
        $new_image = Image::make($image->getRealPath());
        
        if($new_image != null) {
            $file = $image;

            $new_image->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filename = date('ymd') . '_' . time() .'_'. Str::random(10). '.' . $file->getClientOriginalExtension();
            $new_image->save(storage_path('app/public/' . $filepath . $filename));
            $image = $filepath . $filename;

            return $image;
        } 
        return false;

    }

    public function createImageFromBase64Image($image, $width, $height, $filepath){
        // create custom folder with user id if doesn't exist yet
        if(!File::exists($filepath)){
            Storage::disk('public')->makeDirectory($filepath);
        }

        $image_64 = $image; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64); 

        $image = str_replace(' ', '+', $image); 

        $imageName = date('ymd') . '_' . time() .'_'. Str::random(10).'.'.$extension;

        $newImage = base64_decode($image);

        $result = Storage::disk('public')->put($filepath .$imageName, base64_decode($image));
        $imagePath = $filepath . $imageName;
        
        return $imagePath;
    }

    public function copy_files_to_another_folder_using_put_get_function($from, $to){
        // List all the files from a folder
        $fromFiles = Storage::disk('public')->allFiles($from);

        // Using normal get and put (the whole file string at once)
        for ($i=0; $i < count($fromFiles) ; $i++) {
            Storage::disk('public')->put(
                Str::replace($from, $to, $fromFiles[$i]),       // path
                Storage::disk('public')->get($fromFiles[$i])    // content
            );
        }
    }

    // public function copy_files_to_another_folder_using_writestream_get_function(){
    //     // List all the files from a folder
    //     $fromFiles = Storage::disk('public')->allFiles('assets/dummy_recipes');

    //     // Best: using Streams to keep memory usage low (good for large files)
    //     foreach ($fromFiles as $file) {
    //         Storage::disk('public')->writeStream(
    //             Str::replace('assets/dummy_recipes', 'uploads/recipes', $file),         // path
    //             Storage::disk('public')->get($file)                                     // content
    //         );
    //     }
    // }

    // save locally
    // public static function createImage($image, $fileSize, $path){

    //     if($image->getSize() <= $fileSize) {
    //         $extension = $image->extension();
    //         $contents = file_get_contents($image);
    //         $filename = Str::random(25);
    //         $path = "$path.$filename.$extension";

    //         Storage::disk('public')->put($path, $contents);

    //     }
    // }

    // // remove locally
    // public static function removeImage($filename, $path) {
    //     // $extension = $request->file('attachment')->extension();
    //     // $contents = file_get_contents($request->file('attachment'));
    //     // $filename = Str::random(25);
    //     // $path = "product/$filename.$extension";

    //     // Storage::disk('public')->put($path, $contents);
        
    //     // if($oldAttachment = $productDetails->attachment){
    //     //     Storage::disk('public')->delete($oldAttachment);
    //     // }

    //     // $productDetails->update([
    //     //     'attachment' => $path
    //     // ]);
    // }

    // public static function createBase64ImageAfterResizeTempImage($image, $size = ['width' => 150, 'height' => 150], $fileSize)
    // {
    //     try{
    //         $name = "";
            
    //         if($image->getSize() <= $fileSize) {
    //             $new_image = Image::make($image->getRealPath());
        
    //             if($new_image != null){
    //                 $image_width = $new_image->width();
    //                 $image_height = $new_image->height();
        
    //                 $new_width = 500;
    //                 $new_height = 500;
        
    //                 $new_image->resize($new_width, $new_height, function($constraint) {
    //                     $constraint->aspectRatio();
    //                 });
                    
    //                 // $filename = time() . '.' . $image->getClientOriginalExtension();
    //                 // $store_image = $new_image->save(storage_path('app/public/images/temporary/' . $filename));
                    
    //                 // $mime_type = $image->getMimeType() ? $image->getMimeType() : 'image/png';
    //                 // $name = 'data:' . $mime_type . ';base64,' . base64_encode($store_image);
        
    //                 // // remove temp image
    //                 // Storage::disk('public')->delete('images/temporary' . $store_image->basename);

    //                 $extension = $image->extension();
    //                 $contents = file_get_contents($image);
    //                 $filename = Str::random(25);
    //                 $path = "images/temporary/$filename.$extension";

    //                 $store_image = Storage::disk('public')->put($path, $contents);

    //                 $mime_type = $image->getMimeType() ? $image->getMimeType() : 'image/png';
    //                 $name = 'data:' . $mime_type . ';base64,' . base64_encode(Storage::disk('public')->get($path));
        
    //                 // remove temp image
    //                 Storage::disk('public')->delete($path);
    //             }
    //         }else{
    //             throw new Exception('Image attachment with maximum of 1mb filesize.');
    //         }

    //         return $name;
    //     }catch(Throwable $e){
    //         // Call in controller
    //         CustomFile::index('ImageLibrary', 'error', [
    //             'message' => $e->getMessage()
    //         ]);

    //         return false;
    //     }
        
    // }

}

?>