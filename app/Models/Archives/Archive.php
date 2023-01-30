<?php

namespace App\Models\Archives;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\CodeCleaner\ValidConstructorPass;

class Archive extends Model
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
}
