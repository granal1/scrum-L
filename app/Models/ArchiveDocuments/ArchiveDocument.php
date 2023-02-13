<?php

namespace App\Models\ArchiveDocuments;

use App\Models\Tasks\Task;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

class ArchiveDocument extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = '';

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
        'author_uuid',
        'archive_path',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $time = strtotime("-2 year", time());
        $date = date("Y", $time);

        $this->table = Schema::hasTable('archive_files_' . $date) ? 'archive_files_' . $date : 'files';
    }

    protected function setTableName(string $tableName = 'files')
    {
        $this->table = $tableName;
    }

    protected function getTableName()
    {
        return $this->table;
    }

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
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

}
