<?php

namespace App\Services\Tasks;

use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService extends Model
{
    protected $table = 'tasks';

    public function getAuthorCurrentTaskIds()
    {
        return $this::where([
            ['author_uuid', Auth::id()],
            ['deadline_at', '>', now()]
        ])->pluck('id')->all();
    }
}

