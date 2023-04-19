<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageImageTrait
{
    public function storageUploadImage($file, $dir): ?array
    {
        $fileExtension = $file->extension();
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $fileExtension;
        $filePath = $file->storeAs('public/' . $dir . '/' . Auth::id(), $fileNameHash);
        return [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath)
        ];
    }

    public function storageUploadMultipleImage($files, $dir): array
    {
        return collect($files)->map(function ($file) use ($dir) {
            $dataImageUploadMultiple = $this->storageUploadImage($file, $dir);
            return [
                'image_path' => $dataImageUploadMultiple['file_path'],
                'image_name' => $dataImageUploadMultiple['file_name'],
            ];
        })->toArray();
    }

    public function removeFileUpload($filePath): void
    {
        $path = public_path($filePath);
        if (File::exists($path))  File::delete($path);
    }
}
