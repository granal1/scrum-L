<?php

namespace App\Http\Filters\PhoneBook;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PhoneBookFilter extends AbstractFilter
{
    public const POSITION = 'position';
    public const NAME = 'name';
    public const PHONE = 'phone';
    public const EMAIL = 'email';

    protected function getCallbacks(): array
    {
        return [
            self::POSITION => [$this, 'position'],
            self::NAME => [$this, 'name'],
            self::PHONE => [$this, 'phone'],
            self::EMAIL => [$this, 'email'],
        ];
    }

    public function position(Builder $builder, $value)
    {
        $builder->where('position', 'like', "%" . $value . "%");
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%" . $value . "%");
    }
    public function phone(Builder $builder, $value)
    {
        $builder->where('phone', 'like', "%" . $value . "%");
    }

    public function email(Builder $builder, $value)
    {
        $builder->where('email', 'like', "%" . $value . "%");
    }
}
