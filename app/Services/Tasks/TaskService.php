<?php

namespace App\Services\Tasks;

use App\Models\Tasks\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public static function getAuthorCurrentTaskIds()
    {
        $task = new Task();

        return $task::whereHas('currentHistory', function($query){
                return $query->where('deadline_at', '>=', now());
            })
            ->where([
            ['author_uuid', Auth::id()],
        ])
            ->pluck('id')
            ->all();
    }
}

