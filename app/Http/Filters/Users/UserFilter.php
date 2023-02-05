<?php

namespace App\Http\Filters\Users;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const EMAIL = 'email';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::EMAIL => [$this, 'email'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%" . $value . "%");
    }

    public function email(Builder $builder, $value)
    {
        $builder->where('email', 'like', "%" . $value . "%");
    }

}
