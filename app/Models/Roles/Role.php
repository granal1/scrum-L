<?php

namespace App\Models\Roles;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    public const DELO = 'delo';
    public const ADMIN = 'admin';
    public const KADR = 'kadr';
    public const EMPLOYEE = 'employee';
    public const SUPERVISOR = 'supervisor';
    public const MAIN_SUPERVISOR = 'main_supervisor';

    protected $table = "roles";

    protected $fillable = [
        'name',
        'alias'
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_role',
            'role_uuid',
            'user_uuid'
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
