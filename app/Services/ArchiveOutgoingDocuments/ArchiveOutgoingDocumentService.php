<?php

namespace App\Services\ArchiveOutgoingDocuments;

use Illuminate\Support\Facades\DB;

class ArchiveOutgoingDocumentService
{
    public function getYearsList(): array
    {
        $result = [];
        $result[] = date('Y');
        $date = strtotime(date('Y') . ' -1 year');
        $result[] = date('Y', $date);

        foreach (DB::select('SHOW TABLES LIKE "archive_outgoing_files_%"') as $item) {
            foreach ($item as $key => $value) {
                $result[] = substr($value, -4);
            }
        }
        arsort($result);
        return $result;
    }

    public function getLastArchiveYear(): string
    {
        foreach (DB::select('SHOW TABLES LIKE "archive_outgoing_files_%"') as $item) {
            foreach ($item as $key => $value) {
                $result[] = substr($value, -4);
            }
        }
        arsort($result);

        $years = array_reverse($result);
        return array_pop($years);
    }


}
