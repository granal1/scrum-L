<?php

namespace App\Http\Filters\ArchiveOutgoingDocuments;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ArchiveOutgoingDocumentFilter extends AbstractFilter
{
    public const SHORT_DESCRIPTION = 'short_description';
    public const PATH = 'path';
    public const CONTENT = 'content';
    public const OUTGOING_AT = 'outgoing_at';

    protected function getCallbacks(): array
    {
        return [
            self::SHORT_DESCRIPTION => [$this, 'short_description'],
            self::PATH => [$this, 'path'],
            self::CONTENT => [$this, 'content'],
            self::OUTGOING_AT => [$this, 'outgoing_at'],
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

    public function outgoing_at(Builder $builder, $value)
    {
        $builder->whereRaw('outgoing_at', 'like', "%" . $value . "%");
    }
}
