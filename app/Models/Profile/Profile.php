<?php

namespace App\Models\Profile;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Profile extends Authenticatable
{
    use HasUuids;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthday_at',
        'comment',
        'superior_uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function name(){
        return $this->name;
    }

    public function superior()
    {
        return $this->belongsTo(User::class, 'superior_uuid');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'user_role',
            'user_uuid',
            'role_uuid'
        )->wherePivot('deleted_at', null);
    }

    protected function removeQueryParam(string ...$keys)
    {
        foreach($keys as $key)
        {
            unset($this->queryParams[$key]);
        }

        return $this;
    }
}
