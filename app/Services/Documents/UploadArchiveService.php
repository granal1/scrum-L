<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadArchiveService
{
    public function uploadMedia(UploadedFile $uploadedFile): string
    {
        $path = $uploadedFile->storeAs('files/documents/archives/' . date('Y/m/d'), date('Ymd-His') . '.zip', 'public');

        if ($path === false) {
            Log::error('Архив не удалось загрузить на диск');

        }

        return $path;
    }
}
