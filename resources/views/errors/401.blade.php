@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    <span class="text-danger font-bold"> Unauthorized!</span>
    you are not authorized to access this page
@stop
