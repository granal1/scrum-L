<?php

namespace App\Models\ArchivesOutgoingFiles;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchiveOutgoingFile extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = '';

    public function __construct(string $table_name = null)
    {
        $this->table = $table_name;
    }

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
}
