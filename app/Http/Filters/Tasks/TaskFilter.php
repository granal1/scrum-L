<?php

namespace App\Http\Filters\Tasks;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends AbstractFilter
{
    public const DESCRIPTION = 'description';

    protected function getCallbacks(): array
    {
        return [
            self::DESCRIPTION => [$this, 'description'],
        ];
    }

    public function description(Builder $builder, $value)
    {
        $builder->where('description', 'like', "%" . $value . "%");
    }
}
