<?php

namespace App\Models\Roles;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

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

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

}
