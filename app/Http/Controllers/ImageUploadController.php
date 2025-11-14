<?php

namespace App\Http\Controllers;

use App\Traits\ImageOptimizationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    use ImageOptimizationTrait;

    public function upload(Request $request) {
        // Get the uploaded file
        $file = $request->file('file');

        $optimizedImage = $this->optimizeImage($file);

        // Generate a random filename with .webp extension
        $filename = Str::random(32) . '.webp';  // You can adjust the length of the random string

        // Define the local storage path
        $uploadPath = 'tmp/' . $filename;

        // Save the optimized WebP image to local storage
        Storage::disk('public')->put($uploadPath, $optimizedImage->__toString());

        // Return the URL of the stored file
        return "/storage/" . $uploadPath;
    }
}
