<?php

namespace App\Services\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskHistoryService
{
    public static function getResponsibleUserCurrentTaskIds()
    {
        return DB::table('task_histories')->where([
            ['done_progress', '<', 100],
            ['responsible_uuid', 'like', Auth::id()],
            ['deadline_at', '>', now()]
        ])
            ->groupBy('task_uuid')
            ->pluck('task_uuid')
            ->all();
    }

    public static function getResponsibleUserOutstandingTaskIds()
    {
        return DB::table('task_histories')->where([
            ['deadline_at', '<=', now()],
            ['responsible_uuid', 'like', Auth::id()]
        ])
            ->groupBy('task_uuid')
            ->pluck('task_uuid')
            ->all();
    }
}

