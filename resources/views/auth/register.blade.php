<!doctype html>
<html lang="en">

<head>
    <title>Garden of eden | Register</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/parsleyjs/css/parsley.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html,body{
            font-family: 'Raleway', sans-serif!important;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <div class="logo text-center">
                {{--<img src="{{ asset('img/GARDEN_LOGO.png') }}" alt="DiffDash" style="height: 80px">--}}
                <h3>
                    <a href="{{ route('home') }}">
                        {{ env('APP_NAME','Garden Of Eden Produce') }}
                    </a>
                </h3>
            </div>
            <br>
            <div class="auth-box">
                <div class="content">
                    @if(Session::has('message'))
                        <div class="alert alert-danger alert-dismissable flat">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            <p>
                                <i class="fa fa-warning"></i>
                                {{ Session::get('message') }}
                            </p>
                        </div>
                    @endif

                    <div class="header">
                        <p class="lead">
                            Create your account.
                        </p>
                    </div>
                    <form novalidate id="registerForm" class="form-auth-small" action="{{ route('client.create') }}"
                          method="post">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('name')?'has-error':''}}">
                            <label for="signin-name" class="control-label sr-only">Name</label>
                            <input required value="{{Request::old('name')}}" type="text" name="name"
                                   class="form-control"
                                   id="signin-name" placeholder="Full name">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email')?'has-error':''}}">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input  value="{{Request::old('email')}}" type="email" name="email"
                                   class="form-control"
                                   id="signin-email" placeholder="Email address">
                            <small class="text-small">
                                <i class="fa fa-info"></i>
                                This will help in case you forgot your password.</small>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('user_name')?'has-error':''}}">
                            <label for="signin-user_name" class="control-label sr-only">Username</label>
                            <input required value="{{Request::old('user_name')}}" type="text" name="user_name"
                                   class="form-control"
                                   id="signin-user_name" placeholder="Username">
                            @if ($errors->has('user_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password')?'has-error':''}}">
                            <label for="password" class="control-label sr-only">Password</label>
                            <input required minlength="4" type="password" name="password" class="form-control"
                                   id="password"
                                   placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password_confirmation')?'has-error':''}}">
                            <label for="signin-confirm" class="control-label sr-only">Confirm password</label>
                            <input  required minlength="4" data-parsley-equalto="#password" type="password" name="password_confirmation" class="form-control"
                                   id="signin-confirm"
                                   placeholder="Re-type password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-lock"></i>
                            Create my account
                        </button>
                        <div class="bottom">
                            <span class="helper-text">Already have an account?
                                <a href="{{ route('login') }}">Sign in</a>
                            </span>
                        </div>
                        <div class="bottom">
                            <span class="helper-text">
                                <i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center padding-25">
                <small>
                    Made by <span>
                    <a href="mailto:jeanpaulcami@live.com">Jean Paul Byiringiro</a>
                </span>

                    &copy; {{ date('Y') }} .
                </small>
            </p>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
<!-- /.login-box -->


<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Javascript -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('vendor/parsleyjs/js/parsley.min.js') }}"></script>

<script>
    $(function () {
        $('#registerForm').submit(function (e) {
            var form = $(this);
            form.parsley().validate();
            if (form.parsley().isValid()) {
                return true;
            }
            return false;
        });
    });
</script>
</body>
</html>
