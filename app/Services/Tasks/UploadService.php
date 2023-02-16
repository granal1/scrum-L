<?php

namespace App\Services\Tasks;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadService
{
    public function uploadMedia(UploadedFile $uploadedFile): string
    {
        $path = $uploadedFile->storeAs('files/tasks/' . date('Y/m/d/'), $uploadedFile->hashName(), 'public');
        if ($path === false) {
            throw new UploadException("File was not upload");
        }

        return $path;
    }
}
