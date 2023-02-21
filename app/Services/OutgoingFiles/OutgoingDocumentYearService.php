<?php

namespace App\Services\OutgoingFiles;

use App\Models\OutgoingFiles\OutgoingFile;

class OutgoingDocumentYearService
{
    public function getYearsList()
    {      
        $years = OutgoingFile::
            selectRaw('DISTINCT YEAR(`outgoing_at`)')
            ->get()
            ->sortDesc()
            ->pluck('YEAR(`outgoing_at`)');
        return $years;
    }
}
