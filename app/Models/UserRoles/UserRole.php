<?php

namespace App\Models\UserRoles;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "user_role";

    protected $fillable = [
        'user_uuid',
        'role_uuid',
        'comment',
        'sort_order'
    ];

}
