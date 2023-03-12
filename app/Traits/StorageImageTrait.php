<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
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
}
