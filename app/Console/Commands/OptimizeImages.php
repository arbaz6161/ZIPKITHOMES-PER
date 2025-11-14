<?php

namespace App\Console\Commands;

use App\Models\FloorPlanImage;
use App\Models\ProductGroupImage;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize all images in the storage directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Optimize images for FloorplanImage table
        $this->optimizeImagesForTable(FloorPlanImage::all(), 'FloorplanImages');

        // Optimize images for ProductImage table
        $this->optimizeImagesForTable(ProductImage::all(), 'ProductImages');

        // Optimize images for ProductGroupImage table
        $this->optimizeImagesForTable(ProductGroupImage::all(), 'ProductGroupImages');

        $this->info('All images have been optimized and database paths updated.');
    }

    private function optimizeImagesForTable($images, $tableName) {
        foreach ($images as $image) {
            $filePath = storage_path('app/public' . str_replace('storage/', '', $image->pic_url));
            $originolFilePath = $filePath;

            if (!File::exists($filePath) || !$this->isImage(new \SplFileInfo($filePath))) {
                continue;
            }

            // Optimize the image
            $fileContent = File::get($filePath);
            $optimizedImage = $this->optimizeImage($fileContent);

            // Define the new file path
            $filename = pathinfo($image->pic_url, PATHINFO_FILENAME) . '.webp';
            $uploadPath = '/tmp/' . $filename;

            // Save the optimized image
            Storage::disk('public')->put($uploadPath, $optimizedImage->__toString());

            // Update database record with the new path
            $image->pic_url = '/storage' . $uploadPath;
            $image->save();

            // Check if the image was not originally a WebP and delete it
            if (strtolower(pathinfo($originolFilePath, PATHINFO_EXTENSION)) !== 'webp') {
                File::delete($filePath);
                $this->info("Optimized, saved as WebP, deleted original: " . $filename);
            } else {
                $this->info("Optimized and saved as WebP: " . $filename);
            }
        }
    }

    private function isImage($file)
    {
        $mime = File::mimeType($file);
        return str_starts_with($mime, 'image/');
    }

    private function optimizeImage($imageContent)
    {
        // Here you can use your existing image optimization logic
        // For example, you can use the Intervention Image package

        $image = Image::make($imageContent);
        return $image->encode('webp', 90);
    }
}
