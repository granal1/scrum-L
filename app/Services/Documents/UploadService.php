<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadService
{
    public function uploadMedia(UploadedFile $uploadedFile, $now): string
    {
        $path = $uploadedFile->storeAs('files/documents/' .
            date_format($now,"Y/m/d"),
            date_format($now,"Ymd-His") . '.pdf', 'public');

        if ($path === false) {
            Log::error('Файл не удалось загрузить на диск');
        }

        return $path;
    }
}
