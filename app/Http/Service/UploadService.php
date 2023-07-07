<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function uploadFileToFolder(string $disk, string $folderPath, object $file): string
    {
        return Storage::disk($disk)->put($folderPath, $file);
    }

    public function deleteFileOnFolder(string $disk, string $folderPath, string $filePath): void
    {
        Storage::disk($disk)->delete($folderPath . '/' . $filePath);
    }
}
