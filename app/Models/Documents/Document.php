<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "files";

    protected $fillable = [
        'name',
        'path',
        'comment'
    ];

}
