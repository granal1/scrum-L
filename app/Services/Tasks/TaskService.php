<?php

namespace App\Services\Tasks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public static function getAuthorCurrentTaskIds()
    {
        return DB::table('tasks')
            ->where([
            ['author_uuid', Auth::id()]
        ])
            ->pluck('id')
            ->all();
    }
}

