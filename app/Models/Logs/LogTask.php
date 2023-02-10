<?php

namespace App\Models\Logs;

use App\Models\Documents\Document;
use App\Models\OutgoingFiles\OutgoingFile;
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
use Illuminate\Database\Eloquent\Relations\HasOne;

class LogTask extends Model
{

    use  HasFactory, HasUuids, Filterable, SoftDeletes;

    protected $table = "log_task";

    protected $fillable = [
        'id',
        'task_uuid',
        'parent_uuid',
        'author_uuid',
        'responsible_uuid',
        'description',
        'deadline_at',
        'done_progress',
        'report',
        'sort_order',
        'comment',
        'updated_at',
        'deleted_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_uuid'
        );
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'responsible_uuid'
        );
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(
            TaskPriority::class,
            'priority_uuid'
        );
    }
}
