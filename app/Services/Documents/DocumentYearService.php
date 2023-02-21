<?php

namespace App\Services\Documents;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\DB;

class DocumentYearService
{
    public function getYearsList()
    {
        $years = DB::table('files')
            ->selectRaw('DISTINCT YEAR(`incoming_at`)')
            ->get()
            ->sortDesc()
            ->pluck('YEAR(`incoming_at`)');
        return $years;
    }
}
