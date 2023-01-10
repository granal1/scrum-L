<?php

namespace App\Services\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskHistoryService
{
    public static function getResponsibleUserCurrentTaskIds()
    {

        return DB::table('task_histories')
            ->where([
               // ['done_progress', '<', 100],
                //['deadline_at', '>', now()]
            ])
            ->select('task_uuid', 'responsible_uuid', DB::raw('MAX(created_at) as created_at'))
            ->groupBy('responsible_uuid')
            ->having('responsible_uuid', 'like', Auth::id())
            ->get()->value('task_uuid');
    }

    public static function getResponsibleUserOutstandingTaskIds()
    {
        return DB::table('task_histories')
            ->where([
                //['done_progress', '<', 100],
                //['deadline_at', '<=', now()]
            ])
            ->select('task_uuid', 'responsible_uuid', DB::raw('MAX(created_at) as created_at'))
            ->groupBy('responsible_uuid')
            ->having('responsible_uuid', 'like', Auth::id())
            ->get()->value('task_uuid');
    }
}

