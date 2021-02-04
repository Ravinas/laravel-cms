<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime - Giriş Yapın</title>
    <link rel="stylesheet" href="{!! asset("vendor/cms/yeni/css/bootstrap.css")  !!}">

    <link rel="shortcut icon" href="{!! asset("vendor/cms/assets/images/favicon.png") !!}" type="image/x-icon">
    <link rel="stylesheet" href="{!! asset("vendor/cms/yeni/css/app.css")  !!}">
</head>

<body>
    <div id="auth">

<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="{!! asset("vendor/cms/yeni/images/prime-logo.png") !!}" height="78" class='mb-4'>
                        <h3>{{ trans('cms::panel.login') }}</h3>
                        <p>Prime'a devam edebilmek için lütfen giriş yapın./TR</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left">
                            <label for="username">{{ trans('cms::panel.email') }}</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="username" name="email">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                <p class="text-center"> <strong>{{ $message }}</strong></p>
                            </div>
                        @enderror
                        <div class="form-group position-relative has-icon-left">

                            <label for="password">{{ trans('cms::panel.password') }}</label>
                            <div class="position-relative">

                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                            <div class="clearfix">
                                <a href="auth-forgot-password.html" class='float-right'>
                                    <small>Şifrenizi mi unuttunuz?/TR</small>
                                </a>
                            </div>
                        </div>
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                <p class="text-center"> <strong>{{ $message }}</strong></p>
                            </div>
                        @enderror

                        <div class='form-check clearfix my-4'>
                            <div class="checkbox float-left">
                                <input type="checkbox" id="checkbox1" class='form-check-input' >
                                <label for="checkbox1"> {{ trans('cms::panel.remember_me') }}</label>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary float-right">{{ trans('cms::panel.login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="{!! asset('vendor/cms/yeni/js/feather-icons/feather.min.js"') !!} "></script>
    <script src="{!! asset('vendor/cms/yeni/js/app.js"') !!}"></script>
    <script src="{!! asset('vendor/cms/yeni/js/main.js"') !!}"></script>
</body>

</html>
