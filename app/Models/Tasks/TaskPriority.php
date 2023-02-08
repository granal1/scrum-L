<?php

namespace App\Models\Tasks;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskPriority extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "task_priorities";

    protected $fillable = [
        'name',
        'comment',
    ];

    protected function removeQueryParam(string ...$keys)
    {
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }

        return $this;
    }
}
