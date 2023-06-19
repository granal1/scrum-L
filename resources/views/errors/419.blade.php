@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))

{{
    Log::error('Ошибка 419',
    [
        'user' => Auth::user()->name ?? 'Page Expired',
        'url' => $_SERVER['HTTP_HOST'],
    ])
}}

{{
 Request::session()->invalidate(),
 Request::session()->regenerateToken(),
 header('Refresh:1; http://'.$_SERVER['HTTP_HOST'].'/'),
 exit
}}

{{-- как вариант:  header('Refresh:3; http://'.$_SERVER['HTTP_HOST'].'/') --}}
{{-- как вариант:  header('location: http://'.$_SERVER['HTTP_HOST'].'/') --}}