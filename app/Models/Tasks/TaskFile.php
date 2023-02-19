<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskFile extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "task_files";

    protected $fillable = [
        'task_uuid',
        'file_uuid',
        'comment',
        'outgoing_file_uuid',
    ];
}
