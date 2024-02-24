<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Intervention\Image\Facades\Image;

class AvatarController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvatarRequest $request)
    {
        $profile = Profile::where('user_id', auth()->user()->id)->get();

        // resize and compress images
        try{
            if($request->hasFile('avatar')){
                // create custom folder with user id if doesn't exist yet
                $path ='/uploads/profiles/user_' . auth()->user()->id;
                if(!File::exists($path)){
                    Storage::disk('public')->makeDirectory($path);
                }
                
                if(Storage::disk('public')->exists($profile[0]->image) && $profile[0]->image != 'assets/images/default_profile.svg'){
                    Storage::disk('public')->delete($profile[0]->image);
                }

                if(Storage::disk('public')->exists($profile[0]->thumbnail) && $profile[0]->thumbnail != 'assets/images/default_profile.svg'){
                    Storage::disk('public')->delete($profile[0]->thumbnail);
                }

                // image resize logic
                $new_image = Image::make($request->file('avatar')->getRealPath());

                if($new_image != null) {
                    // $image_width = $new_image->width();
                    // $image_height = $new_image->height();

                    $file = $request->file('avatar');

                    // avatar
                    $new_avatar_image = $new_image;
                    $new_avatar_image->fit(100, 100, function($constraint) {
                        $constraint->upsize();
                    });
                    $filename_avatar = 'avatar.' . $file->getClientOriginalExtension();
                    $new_avatar_image->save(storage_path('app/public' . $path . '/' . $filename_avatar));
                    $profile[0]->image = $path . '/' . $filename_avatar;


                    // thumbnail
                    $new_thumbnail_image = $new_image;
                    $new_thumbnail_image->fit(50, 50, function($constraint) {
                        $constraint->upsize();
                    });
                    $filename_thumbnail = 'thumbnail.' . $file->getClientOriginalExtension();
                    $new_thumbnail_image->save(storage_path('app/public' . $path . '/' . $filename_thumbnail));
                    $profile[0]->thumbnail = $path . '/' . $filename_thumbnail;

                    $profile[0]->save();
                }
            }
            return redirect(route('profile.edit'))->with('status','avatar-updated');
            
        }catch(Throwable $e){
            // return redirect(route('profile.edit'))->with('status','error');
        }
    }
}
