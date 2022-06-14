<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">
    <title>Garden of eden @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    @livewireStyles
    <!-- Google font -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @yield('styles')
</head>
<body>
@if(\App\Event::where('active',true)->count()>0)
    <div>
        @foreach(\App\Event::all() as $event)
            <div class="alert alert-info alert-dismissible flat" role="alert"
                 style="margin-bottom: 0!important;background-color: #0067B8;color: white!important;border-color: #0067B8!important;padding:0 20px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        style="color: white!important;margin-right: 20px;">
                    <span aria-hidden="true" style="color: white!important;">&times;</span>
                </button>
                <div class="container" style="font-weight: lighter !important;">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $event->description !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- HEADER -->
@include('partials.header')
<!-- /HEADER -->

<!-- NAVIGATION -->
@include('partials.nav')
<!-- /NAVIGATION -->

<!-- SECTION -->
@yield('content')
<!-- FOOTER -->
@include('partials.footer')
<!-- /FOOTER -->

@livewireScripts
<script src="{{ mix('js/app.js') }}" ></script>
@yield('scripts')

</body>
</html>
