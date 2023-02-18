<?php

namespace App\Http\Filters\Users;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class UserStatusFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const ALIAS = 'alias';


    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::ALIAS => [$this, 'alias'],

        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%" . $value . "%");
    }

    public function alias(Builder $builder, $value)
    {
        $builder->where('alias', 'like', "%" . $value . "%");
    }
}
