<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHandlerService
{
    private ImageManager $imageManager;
    
    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }
    
    /**
     * Process and store multiple images
     */
    public function handleMultipleUploads(array $images, string $folder = 'listings'): array
    {
        $uploadedImages = [];
        
        foreach ($images as $index => $image) {
            $uploadedImages[] = $this->handleSingleUpload($image, $folder, $index === 0);
        }
        
        return $uploadedImages;
    }
    
    /**
     * Process and store a single image
     */
    private function handleSingleUpload(UploadedFile $image, string $folder, bool $isCover = false): array
    {
        // Create image instance
        $img = $this->imageManager->read($image->getRealPath());
        
        // Resize if needed (maintaining aspect ratio)
        $img->scaleDown(1200, 1200);
        
        // Convert to WebP for better compression
        $processed = $img->toWebp(80);
        
        // Generate unique filename
        $filename = uniqid() . '.webp';
        $path = $folder . '/' . $filename;
        
        // Store in S3
        Storage::disk('s3')->put(
            $path,
            $processed->toString(),
            ['visibility' => 'public']
        );
        
        return [
            'path' => $path,
            'url' => Storage::disk('s3')->url($path),
            'is_cover' => $isCover,
            'size' => $processed->size(),
            'width' => $img->width(),
            'height' => $img->height()
        ];
    }
}