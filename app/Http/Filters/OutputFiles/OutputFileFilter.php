<?php

namespace App\Http\Filters\OutputFiles;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class OutputFileFilter extends AbstractFilter
{
    public const SHORT_DESCRIPTION = 'short_description';
    public const PATH = 'path';


    protected function getCallbacks(): array
    {
        return [
            self::SHORT_DESCRIPTION => [$this, 'short_description'],
            self::PATH => [$this, 'path'],

        ];
    }

    public function short_description(Builder $builder, $value)
    {
        $builder->where('short_description', 'like', "%" . $value . "%");
    }

    public function path(Builder $builder, $value)
    {
        $builder->where('path', 'like', "%" . $value . "%");
    }
}
