<?php

namespace App\Http\Filters\Tasks;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskPriorityFilter extends AbstractFilter
{
    public const PRIORITY_UUID = 'priority_uuid';

    protected function getCallbacks(): array
    {
        return [
            self::PRIORITY_UUID => [$this, 'priority_uuid'],
        ];
    }

    public function priority_uuid(Builder $builder, $value)
    {
        $builder->find($value);
    }
}
