<?php

namespace App\Models\OutputFiles;

use App\Models\Tasks\Task;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutputFile extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "output_files";

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
        'author_uuid'
    ];

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

}
