<?php

namespace App\Services\ArchiveDocuments;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ArchiveDocumentService
{
    public function getYearsList(): array
    {
        $result = [];
        $result[] = date('Y');
        $date = strtotime(date('Y') . ' -1 year');
        $result[] = date('Y', $date);


        if(Schema::hasTable('archive_files_%'))
        {
            foreach (DB::select('SHOW TABLES LIKE "archive_files_%"') as $item) {
                foreach ($item as $key => $value) {
                    $result[] = substr($value, -4);
                }
            }

            if(!empty($result)){
                arsort($result);
                return $result;
            }
        }

       return [];
    }

    public function getLastArchiveYear(): string
    {
        if(Schema::hasTable('archive_files_%')) {
            foreach (DB::select('SHOW TABLES LIKE "archive_files_%"') as $item) {
                foreach ($item as $key => $value) {
                    $result[] = substr($value, -4);
                }
            }
            if (!empty($result)) {
                arsort($result);

                $years = array_reverse($result);
                return array_pop($years);
            }
        }

        return '';
    }


}
