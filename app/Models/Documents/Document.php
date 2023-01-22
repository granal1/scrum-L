<?php

namespace App\Models\Documents;

use App\Models\Tasks\Task;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use JamesMills\LaravelTimezone\Facades\Timezone;

class Document extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "files";
    protected $casts = [
        'incoming_at' => 'datetime',
        'date' => 'datetime',
        'executed_at' => 'datetime',
    ];

    protected $fillable = [
        'short_description',
        'path',
        'comment',
        'incoming_at',
        'incoming_number',
        'incoming_author',
        'number',
        'date',
        'document_and_application_sheets',
        'file_mark',
        'executed_result',
        'executed_at',
        'author_uuid'
    ];


    public function tasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_files',
            'file_uuid',
            'task_uuid'
        )->wherePivot('deleted_at', null);
    }

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

    public function getIncomingAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getDateAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getExecutedAtAttribute($value) 
    {
        return Timezone::convertToLocal(new Carbon($value));
    }

    public function getDeleteddAtAttribute($value) 
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

}
