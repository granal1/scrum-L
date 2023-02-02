<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if ( !function_exists('no_inject') ) {
    function no_inject(string $data): string
    {
        $clear_data = (string) Str::of($data)
            ->lower()
            ->remove(config('stop-list'))
            ->remove('\'')
            ->ltrim(' ')
            ->rtrim(' ')
            ->replaceMatches('/\s+/', ' ');

        return $clear_data;
    }

    if ( !function_exists('archive_document_list') ) {
        function archive_document_list(){
            $result = [];

            foreach (DB::select('SHOW TABLES LIKE "archive_files_%"') as $item){
                foreach($item as $key => $value){
                    $result[substr($value, -4)] = $value;
                }
            }
            return $result;
        }
    }

    if ( !function_exists('archive_outgoing_list') ) {
        function archive_outgoing_list(){
            $result = [];

            foreach (DB::select('SHOW TABLES LIKE "archive_outgoing_files_%"') as $item){
                foreach($item as $key => $value){
                    $result[substr($value, -4)] = $value;
                }
            }
            return $result;
        }
    }
}
