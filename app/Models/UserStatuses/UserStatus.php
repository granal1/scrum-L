<?php

namespace App\Models\UserStatuses;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserStatus extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $table = "user_status";

    protected $fillable = [
        'name',
        'alias',
        'comment',
        'sort_order'
    ];

}
