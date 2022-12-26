<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public const DELO = 'delo';
    public const ADMIN = 'admin';
    public const GUEST = 'guest';
    public const KADR = 'kadr';
    public const USER = 'user';

    protected $table = "roles";

    protected $fillable = [
        'name',
        'alias'
    ];

}
