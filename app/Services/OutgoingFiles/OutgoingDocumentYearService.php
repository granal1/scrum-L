<?php

namespace App\Services\OutgoingFiles;

use App\Models\OutgoingFiles\OutgoingFile;

class OutgoingDocumentYearService
{
    public function getYearsList()
    {
        $years = OutgoingFile::groupBy('outgoing_at')->get()->pluck('outgoing_at')->map(function($item, $key){
            return date('Y', strtotime($item));
        });

        return $years;
    }
}
