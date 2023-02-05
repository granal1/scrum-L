<?php

namespace App\Services\OutgoingFiles;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadArchiveService
{
    public function uploadMedia(UploadedFile $uploadedFile, $now): string
    {
        $path = $uploadedFile->storeAs('files/output_files/archives/' . 
            date_format($now,"Y/m/d"),
            date_format($now,"Ymd-His") . '.zip', 'public');

        if ($path === false) {
            Log::error('Архив не удалось загрузить на диск');
        }

        return $path;
    }
}
