<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;

class ImageOptimizer
{
    protected ImageManager $manager;

    public function __construct(
        protected int   $maxWidth  = 1920,
        protected int   $maxHeight = 1920,
        protected int   $quality   = 80,
        protected array $formats   = ['webp', 'jpg', 'jpeg']
    ) {
        $this->manager = new ImageManager(new Driver());
    }

    public function optimizeAndSave(UploadedFile|string $file, string $directory, string $targetFormat = 'webp'): array
    {
        $tmpPath = $file instanceof UploadedFile ? $file->getPathname() : $file;

        $originalSize  = filesize($tmpPath);
        $image         = $this->manager->read($tmpPath);
        $dimensions    = $image->size();
        $originalW     = $dimensions->width();
        $originalH     = $dimensions->height();

        if ($originalW > $this->maxWidth || $originalH > $this->maxHeight) {
            $image = $image->scaleDown($this->maxWidth, $this->maxHeight);
        }

        $disk       = config('filesystems.default') === 'public' ? 'public' : 'public';
        $storagePath = storage_path('app/public/' . $directory);
        if (! is_dir($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        $filename    = \Illuminate\Support\Str::uuid() . '.' . $targetFormat;
        $targetPath  = $storagePath . '/' . $filename;

        $encoded = match (strtolower($targetFormat)) {
            'webp'  => $image->toWebp($this->quality),
            'jpg', 'jpeg' => $image->toJpeg($this->quality),
            'png'   => $image->toPng(),
            default => $image->toWebp($this->quality),
        };

        $encoded->save($targetPath);

        $newSize = filesize($targetPath);

        return [
            'path'         => $directory . '/' . $filename,
            'filename'     => $filename,
            'original_w'   => $originalW,
            'original_h'   => $originalH,
            'original_size'=> $originalSize,
            'optimized_size'=> $newSize,
            'saved_percent' => $originalSize > 0
                ? round((1 - $newSize / $originalSize) * 100, 1)
                : 0,
        ];
    }

    public static function handleUploadedFile($file, string $directory = 'products', string $format = 'webp'): string
    {
        $optimizer = new self();
        $result = $optimizer->optimizeAndSave($file, $directory, $format);
        return str_replace('\\', '/', $result['path']);
    }
}
