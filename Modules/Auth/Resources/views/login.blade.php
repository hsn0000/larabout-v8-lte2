<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <!-- meta vieport -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="{{ asset('themes/img/AdminLTELogo.png') }}" rel="shortcut icon">

        <!-- Load general CSS -->
        <link rel="stylesheet" href="{{ asset('themes/css/app.css') }}">

        <!-- Load custom CSS -->
        <link rel="stylesheet" href="{{ asset('module/css/auth.css') }}">
    </head>
    <body class="hold-transition login-page" style="background: rgb(43 34 52) !important;">
        <div id="overlay"></div>
        <div class="login-box">
            <div class="login-logo">
                {{--<img src="{{ asset('themes/img/AdminLTELogo.png') }}" alt="" width="70%">--}}
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                {{ general()->flash_message() }}
                <form action="#" method="post" autocomplete="off" id="form-login">
                    @csrf
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Username" name="username">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="input-group captcha">
                        <div class="input-group-addon captcha-image">{!! captcha_img() !!}</div>
                        <input type="text" class="form-control" placeholder="Captcha" autocomplete="off" name="captcha" maxlength="6">
                        <div class="input-group-addon captcha-refresh"><a href="javascript:void(1)" ><i class="fa fa-refresh"></i></a></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <a href="" @class('forgot-password')>forgot password ?</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="button" class="btn btn-default do-login btn-block"><i class="fa fa-spinner fa-pulse loading"></i> Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <script src="{{ asset('themes/js/app.js') }}"></script>
        <script src="{{ asset('module/js/auth.js') }}"></script>
    </body>
</html>
