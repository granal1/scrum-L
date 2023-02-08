<?php

use Illuminate\Support\Str;

if (! function_exists('no_inject')) {
    function no_inject(string $data): string
    {
        $clear_data = (string) Str::of($data)
            ->lower()
            ->remove(config('stop-list'))
            ->remove('\'')
            ->ltrim(' ')
            ->rtrim(' ')
            ->replaceMatches('/\s+/', ' ');

        return $clear_data;
    }
}

if (! function_exists('translate_repeat_period')) {
    function translate_repeat_period(string $period): string
    {
        switch($period) {
            case('months'):
                return 'месяц';

            case('years'):
                return 'год';

            default:
                return 'день';
        }
    }
}
