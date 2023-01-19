<?php

namespace App\Services\OutgoingFiles;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadArchiveService
{
    public function uploadMedia(UploadedFile $uploadedFile): string
    {
        $path = $uploadedFile->storeAs('files/output_files/archives/' . date('Y/m/d'), date('Ymd-His') . '.zip', 'public');

        if ($path === false) {
            throw new UploadException("Archive was not upload");
        }

        return $path;
    }
}
