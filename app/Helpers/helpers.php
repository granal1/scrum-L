<?php

use Illuminate\Support\Str;

if (! function_exists('no_inject')) {
    function no_inject(string $data): string
    {
        $clear_data = (string) Str::of($data)
            ->lower()
            ->remove(config('stop-list'))
            ->ltrim(' ')
            ->rtrim(' ')
            ->replaceMatches('/\s+/', ' ');

        return $clear_data;
    }
}
