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
use Illuminate\Support\Carbon;
use JamesMills\LaravelTimezone\Facades\Timezone;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "tasks";
    protected $casts = [
        'deadline_at' => 'datetime',
    ];

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

    public function currentAuthor() //TODO вроде в формах больше не используется
    {
        return $this->authors->last()->name;
    }

    public function getAuthor()
    {
        return User::find($this->author_uuid)->name;
    }

    public function getResponsible()
    {
        return User::find($this->responsible_uuid)->name;
    }

    public function currentResponsible() //TODO вроде в формах больше не используется
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

    public function getDeadlineAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getCreatedAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getUpdatedAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getDeletedAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function setDeadlineAtAttribute($value)
    {
        $this->attributes['deadline_at'] = Timezone::convertFromLocal($value);
    }

}
