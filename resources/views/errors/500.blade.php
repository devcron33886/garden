@extends('errors::illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    <span class="text-danger font-bold">Oops!</span>
    Something went wrong here.
    We're working on it and we'll get it fixed as soon possible.You can back or call <a href="tel:0728177613" class="small">+250 728 177 613</a> .
@stop
