

        <!doctype html>
<html lang="en">

<head>
    <title>Garden of eden |  Reset password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">


    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Javascript -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <h3 class="text-center text-uppercase">
                <a href="{{ route('home') }}">
                    {{ _('Garden Of Eden Produce') }}
                </a>
            </h3>
            <div class="auth-box">

                <div class="content">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="header">
                        <div class="logo text-center">

                            {{--<img src="{{ asset('img/GARDEN_LOGO.png') }}" alt="DiffDash" style="height: 80px">--}}
                        </div>
                        <p class="lead">
                            {{ __('Reset Password') }}
                        </p>
                    </div>
                    <form method="POST" action="{{ url('password/reset') }}" class="form-auth-small">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

                            <div>
                                <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">{{ __('Password') }}</label>

                            <div>
                                <input placeholder="{{ __('Password') }}" id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
                            <div>
                                <input placeholder="{{ __('Confirm Password') }}" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-lock"></i>
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
<!-- /.login-box -->
</body>
</html>






