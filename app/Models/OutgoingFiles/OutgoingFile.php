<?php

namespace App\Models\OutgoingFiles;

use App\Models\Tasks\Task;
use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutgoingFile extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "outgoing_files";

    protected $fillable = [
        'short_description',
        'path',
        'comment',
        'outgoing_at',
        'outgoing_number',
        'outgoing_author',
        'number_of_source_document',
        'date_of_source_document',
        'document_and_application_sheets',
        'file_mark',
        'author_uuid',
        'executor_uuid',
        'archive_path',
    ];

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_uuid');
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
