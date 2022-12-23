<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadService
{
    public function uploadMedia(UploadedFile $uploadedFile, $name = null): string
    {
        $path = $uploadedFile->storeAs('files/documents/' . date('Y/m/d'), $name, 'public');
        if ($path === false) {
            throw new UploadException("File was not upload");
        }

        return $path;
    }
}
