<?php

namespace App\Models\Tasks;

use App\Models\Documents\Document;
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
        'description',
        'comment',
        'author_uuid'
    ];

    public function histories()
    {
        return $this->hasMany(TaskHistory::class, 'task_uuid', 'id');
    }

    public function currentHistory()
    {
        return $this->hasOne(TaskHistory::class, 'task_uuid')->latestOfMany();
    }

    public function priorities(): BelongsToMany
    {
       return $this->belongsToMany(
           TaskPriority::class,
           'task_histories',
           'task_uuid',
           'priority_uuid'
       );
    }

    public function responsibles(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'task_histories',
            'task_uuid',
            'responsible_uuid'
        );
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'task_histories',
            'task_uuid',
            'user_uuid'
        );
    }

    public function currentAuthor()
    {
        return $this->authors->last()->name;
    }

    public function currentResponsible()
    {
        return $this->responsibles->last()->name;
    }

    public function currentPriority()
    {
        return $this->priorities->last()->name;
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

    public static function boot() {
        parent::boot();

        static::deleting(function($task) {
            $task->histories()->delete();
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
