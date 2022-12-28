<?php

namespace App\Models\Tasks;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskHistory extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "task_histories";

    protected $fillable = [
        'priority_uuid',
        'parent_uuid',
        'user_uuid',
        'task_uuid',
        'responsible_uuid',
        'done_progress',
        'deadline_at',
        'comment',
        'sort_order',
    ];

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }
}
