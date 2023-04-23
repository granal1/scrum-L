<?php

namespace App\Services\SiteLogs;

use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteLogService extends Model
{
   public function getAll()
   {

       $link = Storage::disk('site_logs')->url('logs');

       $links = [];

       foreach($this->getAllDates() as $date)
       {
           $links[] = $link . '/' . $date . '/laravel.log';
       }

       return $links;
   }

   public function getAllDates()
   {
       $dates = array_filter(
           scandir(storage_path() . '/logs'),
           fn($fn) => !str_starts_with($fn,'.') // filter everything that begins with dot
       );

       return $dates;
   }
}

