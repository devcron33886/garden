<!doctype html>
<html lang="en">

<head>
    <title>Garden of eden | Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ mix('css/master.css') }}" rel="stylesheet">
    <style>
        html,
        body {
            font-family: 'Raleway', sans-serif !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="height: 100vh!important;">
        <div class="row flex-center">
            <div class="col-md-4 col-lg-3 col-sm-6 col-xs-11">
                <div class="shadow-sm rounded-sm panel panel-default">
                    <div class="panel-heading bg-white no-border">
                        <div class="logo text-center">
                            <img src="{{ asset('img/GARDEN_LOGO.png') }}" alt="DiffDash" style="height: 80px">
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="lead text-center">
                            <strong>
                                Login to your account
                            </strong>
                        </p>
                        <form class="form-auth-small" autocomplete="off" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-end">{{ __('Email') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input type="checkbox" name="remember" value="1" checked>
                                    <span>Remember me</span>
                                </label>
                            </div>
                            <button type="submit"
                                class="btn btn-success text-uppercase btn-block rounded-sm shadow-sm">
                                <i class="fa fa-sign-in"></i>
                                Sign in
                            </button>

                        </form>
                    </div>
                    <div class="panel-footer bg-white no-border">
                        <a class="text-muted mb-3 d-block" href="{{ route('password.request') }}">Forgot password ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
