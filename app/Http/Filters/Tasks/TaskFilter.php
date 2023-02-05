<?php

namespace App\Http\Filters\Tasks;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends AbstractFilter
{
    public const DESCRIPTION = 'description';
    public const PRIORITY_UUID = 'priority_uuid';

    protected function getCallbacks(): array
    {
        return [
            self::DESCRIPTION => [$this, 'description'],
            self::PRIORITY_UUID => [$this, 'priority_uuid'],
        ];
    }

    public function description(Builder $builder, $value)
    {
        $builder->where('description', 'like', "%" . $value . "%");
    }

    public function priority_uuid(Builder $builder, $value)
    {
        $builder->where('priority_uuid', 'like', $value);
    }
}
