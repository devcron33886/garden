<?php

?>

@extends('layouts.app')

@section('title')
    Profile
@endsection
@section('content')

    <br>
    <div class="section">
        <div class="container">
            <div class="row">
                <section class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success flat" role="alert">
                          <i class="fa fa-check-circle"></i>  {{ session('status') }}
                        </div>
                    @endif
                    <h4>
                        <i class="fa fa-user"></i>
                        My profile</h4>

                </section>

            </div>
        </div>
    </div>
    <br>
    <br>
@endsection