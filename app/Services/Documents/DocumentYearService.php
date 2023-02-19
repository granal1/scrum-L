<?php

namespace App\Services\Documents;

use App\Models\Documents\Document;

class DocumentYearService
{
    public function getYearsList()
    {
        $years = Document::groupBy('incoming_at')->get()->pluck('incoming_at')->map(function($item, $key){
            return date('Y', strtotime($item));
        })->unique()->sortDesc();

        return $years;
    }
}
