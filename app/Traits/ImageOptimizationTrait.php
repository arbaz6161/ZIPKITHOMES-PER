<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait ImageOptimizationTrait
{
    public function optimizeImage($file, $quality = 90)
    {
        // Load the image using Intervention Image
        $img = Image::make($file->getRealPath());

        // Optimize and convert to WebP
        return $img->encode('webp', $quality);
    }
}
