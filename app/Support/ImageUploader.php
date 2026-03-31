<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploader
{
    /**
     * Optimize and upload an image/file to the given S3 folder.
     * Images are resized to fit within the max box while keeping aspect ratio
     * and encoded to JPEG to trim size; non-images are passed through unchanged.
     */
    public function upload(UploadedFile $file, string $directory, int $maxWidth = 1400, int $maxHeight = 1400, int $quality = 82): string
    {
        $isImage = Str::startsWith($file->getMimeType(), 'image/');

        $baseName = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $finalName = $isImage
            ? $baseName . '.jpg'
            : $baseName . '.' . strtolower($file->getClientOriginalExtension());

        if ($isImage) {
            $image = Image::read($file->getPathname())
                ->scaleDown(width: $maxWidth, height: $maxHeight);

            $encoded = $image->encode(new JpegEncoder(quality: $quality));

            Storage::disk('s3')->put("{$directory}/{$finalName}", (string) $encoded);
        } else {
            Storage::disk('s3')->put("{$directory}/{$finalName}", file_get_contents($file));
        }

        return $finalName;
    }
}
