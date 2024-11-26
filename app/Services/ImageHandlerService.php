<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHandlerService
{
    private $manager;

    public function __construct()
    {
        // New way to initialize ImageManager in v3
        $this->manager = new ImageManager(new Driver());
    }

    public function handleMultipleUploads($images)
    {
        if (!$images) {
            return [];
        }

        $processedImages = [];

        foreach ($images as $image) {
            $processedImages[] = $this->handleSingleUpload($image);
        }

        return $processedImages;
    }

    private function handleSingleUpload($image)
    {
        // Generate a unique filename
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        
        // Create an instance of intervention image
        $img = $this->manager->read($image); // Note the change from 'make' to 'read'
        
        // Resize if needed while maintaining aspect ratio
        $img->scale(width: 1200);

        // Store the processed image
        $path = 'listings/' . $filename;
        Storage::disk('public')->put($path, $img->toJpeg());

        // Return the path and any additional metadata you want to store
        return [
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'original_name' => $image->getClientOriginalName(),
            'size' => $image->getSize(),
            'mime_type' => $image->getMimeType(),
        ];
    }
}