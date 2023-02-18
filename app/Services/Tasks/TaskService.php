<?php

namespace App\Services\Tasks;

use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskService extends Model
{
    protected $table = 'tasks';

    public function getCurrentTaskIds()
    {
        return Task::where(function ($query) {
            $query->where('responsible_uuid', Auth::id())
                ->orWhere('author_uuid', Auth::id());
        })
            ->where([
                ['deadline_at', '>', now()],
                ['done_progress', '<', 100]
            ])
            ->get()
            ->pluck('id')
            ->all();
    }

    public function getOutstandingTaskIds()
    {
        return Task::where(function ($query) {
            $query->where('responsible_uuid', Auth::id())
                ->orWhere('author_uuid', Auth::id());
        })
            ->where([
                ['deadline_at', '<=', now()],
                ['done_progress', '<', 100]
            ])
            ->get()
            ->pluck('id')
            ->all();
    }
}

