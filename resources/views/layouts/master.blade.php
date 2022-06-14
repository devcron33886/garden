<!doctype html>
<html lang="en">
<head>
    <title>Garden of eden | @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    @yield('styles')
    <link href="{{ mix('css/master.css') }}" rel="stylesheet">
</head>
<body>

<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
@include('shared.header')
<!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
@include('shared.left')
<!-- END LEFT SIDEBAR -->
    <!-- MAIN CONTENT -->
    <div id="main-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->
<div class="clearfix"></div>
<footer>
    <p class="copyright">&copy; {{ date('Y') }}
        <a href="" target="_blank">
            <b>jean paul CaMi Byiringiro</b>
        </a>. All Rights Reserved.
    </p>
</footer>

<!-- jQuery Plugins -->
<script src="{{ mix('js/master.js') }}"></script>
@yield('scripts')
</body>
</html>
