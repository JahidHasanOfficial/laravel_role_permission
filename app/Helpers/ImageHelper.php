<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    // Upload image
    public static function upload($file, $path = 'uploads')
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/' . $path, $fileName);
        return $path . '/' . $fileName;
    }

    // Delete image
    public static function delete($filePath)
    {
        if ($filePath && Storage::exists('public/' . $filePath)) {
            Storage::delete('public/' . $filePath);
            return true;
        }
        return false;
    }

    // Get image URL
    // public static function get($filePath)
    // {
    //     if ($filePath && Storage::exists('public/' . $filePath)) {
    //         return asset('storage/' . $filePath);
    //     }
    //     return asset('default.png'); // default image
    // }

public static function get($filePath)
{
    if (!$filePath) {
        return asset('default.png');
    }

    $filePath = str_replace('public/', '', $filePath);

    if (Storage::exists('public/' . $filePath)) {
        return asset('storage/' . $filePath);
    }

    return asset('default.png');
}


}
