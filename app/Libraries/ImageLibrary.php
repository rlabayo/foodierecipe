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

    /**
     * Function to create base64 image code 
     */

    public static function createBase64Image($image, $fileSize, $resize = ['width' => 150, 'height' => 150]){
        $name = "";

        if($image->getSize() <= $fileSize) {
            $mime_type = $image->getMimeType() ? $image->getMimeType() : 'image/png';
            $name = 'data:' . $mime_type . ';base64,' . base64_encode(file_get_contents($image));
        }
        return $name;
    }


    /**
     * Function to create image in storage from image input file
     */

    public function createImage($image,int $width = 460,int $height = 400, $filepath){
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

    /**
     * Function to create image from base64 image code
     */

    public function createImageFromBase64Image($image, $filepath, $width=560, $height=560){
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
        base64_decode($image);

        // resize images
        $resized_image = Image::make(base64_decode($image))->resize($width, $height);

        Storage::disk('public')->put($filepath .$imageName, (string) $resized_image->encode());
        $imagePath = $filepath . $imageName;
        
        return $imagePath;
    }

    /**
     * Function to copy files from 1 folder to another folder using put and get function
     */

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

    /**
     * Function to delete old images
     */

     public function delete_stored_image($image){
        if(Storage::disk('public')->exists($image)){
            Storage::disk('public')->delete($image);
        }
    }

}

?>