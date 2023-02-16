<?php

namespace App\Http\Filters\ArchiveDocuments;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ArchiveDocumentFilter extends AbstractFilter
{
    public const SHORT_DESCRIPTION = 'short_description';
    public const PATH = 'path';
    public const CONTENT = 'content';
    public const INCOMING_AT = 'incoming_at';

    protected function getCallbacks(): array
    {
        return [
            self::SHORT_DESCRIPTION => [$this, 'short_description'],
            self::PATH => [$this, 'path'],
            self::CONTENT => [$this, 'content'],
            self::INCOMING_AT => [$this, 'incoming_at'],
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

    public function content(Builder $builder, $value)
    {
        $builder->whereRaw("MATCH(content) AGAINST('" . $value . "')");
    }

    public function incoming_at(Builder $builder, $value)
    {
        $builder->whereRaw('incoming_at', 'like', "%" . $value . "%");
    }
}
