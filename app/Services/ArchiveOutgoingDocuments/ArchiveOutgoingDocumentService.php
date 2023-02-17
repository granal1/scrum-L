<?php

namespace App\Services\ArchiveOutgoingDocuments;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

            if(!empty($result)){
                arsort($result);
                return $result;
            }


        return [];
    }

    public function getLastArchiveYear(): string
    {

            foreach (DB::select('SHOW TABLES LIKE "archive_outgoing_files_%"') as $item) {
                foreach ($item as $key => $value) {
                    $result[] = substr($value, -4);
                }
            }
            if (!empty($result)) {
                arsort($result);

                $years = array_reverse($result);
                return array_pop($years);
            }


        return '';
    }


}
