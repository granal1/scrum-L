<?php

namespace App\Models\Tasks;

use App\Models\Documents\Document;
use App\Models\OutgoingFiles\OutgoingFile;
use App\Models\Periods\Period;
use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "tasks";

    protected $fillable = [
        'parent_uuid',
        'priority_uuid',
        'author_uuid',
        'responsible_uuid',
        'description',
        'deadline_at',
        'done_progress',
        'report',
        'sort_order',
        'comment',
        'repeat_period',
        'repeat_value',
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
                    'responsible_uuid'
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_uuid'
        );
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(
            TaskPriority::class,
                    'priority_uuid'
        );
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(
            Document::class,
            'task_files',
            'task_uuid',
            'file_uuid'
        )->wherePivot('deleted_at', null);
    }

    public function outgoing_documents(): BelongsToMany
    {
        return $this->belongsToMany(
            OutgoingFile::class,
            'task_files',
            'task_uuid',
            'outgoing_file_uuid'
        )->wherePivot('deleted_at', null);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($task) {
            $task->documents()->delete();
        });
    }

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

}
