<?php

namespace App\utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\returnSelf;

class ImageManger
{


    public static function uploadImages($request, $post = null, $user = null)
    {

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $file = self::generateImageName($image);
                $path = self::storeImageInLocale($image, 'posts', $file);

                if ($post && $post->images()) {
                    $post->images()->create([
                        'path' => $path,
                    ]);
                }
            }
        }
        // upload single image 
        if ($request->hasFile('image')) {
            $image = $request->file('image');

         if($user){
            self::delteImageFromLocale($user->image);

            $file = self::generateImageName($image);
            $path = self::storeImageInLocale($image, 'users', $file);

            $user->update(['image' => $path]);
         }
        }
    }

    public static function deleteImages($post)
    {
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {
                if (File::exists(public_path($image->path))) {
                    File::delete(public_path($image->path));
                }
            }
        }
    }


    public static function updateImages($user, $request)
    {
        $image = $request->image;
        if (File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        // strore image in local 
        $file = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('uploads/users', $file, ['disk' => 'uploads']);
        $user->update(['image' => $path]);
    }

    public static function delteImageFromLocale($image_path)
    {
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
    }

    public static function generateImageName($image)
    {
        $file_name = Str::uuid() . time() .'.'. $image->getClientOriginalExtension();
        return $file_name;
    }

 
    public static function storeImageInLocale($image, $path, $file_name)
    {
        $path = $image->storeAs('uploads/' . $path, $file_name,  ['disk' => 'uploads']);
        return $path;
    }
}
 