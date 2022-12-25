<?php

namespace App\Http\Filters\Documents;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class DocumentFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const PATH = 'path';


    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::PATH => [$this, 'path'],

        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%" . $value . "%");
    }

    public function path(Builder $builder, $value)
    {
        $builder->where('path', 'like', "%" . $value . "%");
    }
}
