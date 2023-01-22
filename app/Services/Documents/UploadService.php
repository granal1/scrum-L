<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UploadService
{
    public function uploadMedia(UploadedFile $uploadedFile): string
    {
        $path = $uploadedFile->storeAs('files/documents/' . 
            date_format(date_create("now", timezone_open(session('localtimezone'))),"Y/m/d"), 
            date_format(date_create("now", timezone_open(session('localtimezone'))),"Ymd-His") . '.pdf', 'public');
        if ($path === false) {
            throw new UploadException("File was not upload");
        }

        return $path;
    }
}
