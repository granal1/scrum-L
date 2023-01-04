<?php

namespace App\Models\Documents;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "files";

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
        'task_description',
        'executor',
        'deadline_at',
        'executed_result',
        'executed_at',
        'file_mark'
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
