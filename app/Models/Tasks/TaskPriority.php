<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskPriority extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "task_priorities";

    protected $fillable = [
        'name',
        'comment'
    ];
}
