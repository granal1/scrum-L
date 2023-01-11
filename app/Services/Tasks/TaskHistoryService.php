<?php

namespace App\Services\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskHistoryService extends Model
{

    protected $table = "task_histories";

    public function getCurrentTaskIds()
    {
        return collect($this::latest()
            ->get()
            ->unique('task_uuid')
            ->filter(function($key){
                return ($key->responsible_uuid === Auth::id() || $key->user_uuid === Auth::id()) && $key->deadline_at > now() && $key->done_progress < 100;
            })
            ->values()
            ->all())
            ->pluck('task_uuid')
            ->all();
    }

    public function getOutstandingTaskIds()
    {
        return collect($this::latest()
            ->get()
            ->unique('task_uuid')
            ->filter(function($key){
                return ($key->responsible_uuid === Auth::id() || $key->user_uuid === Auth::id()) && $key->deadline_at <= now() && $key->done_progress < 100;
            })
            ->values()
            ->all())
            ->pluck('task_uuid')
            ->all();
    }

}

