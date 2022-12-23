<?php

namespace App\Models\Tasks;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "tasks";

    protected $fillable = [
        'description',
        'comment'
    ];

    public function histories()
    {
        return $this->hasMany(TaskHistory::class, 'task_uuid', 'id');
    }

    public function currentHistory()
    {
        return $this->hasOne(TaskHistory::class, 'task_uuid')->latestOfMany();
    }

    public function getPriority()
    {
        return TaskPriority::find($this->currentHistory->priority_uuid)->name;
    }

    public function getResponsible()
    {
        return User::find($this->currentHistory->responsible_uuid)->name;
    }

    public function getAuthor()
    {
        return User::find($this->currentHistory->user_uuid)->name;
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($task) {
            $task->histories()->delete();
        });
    }

}
