<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset("assets/images/favicon.png") !!}">
    <title>EKMEK TEKNESİ</title>
    <!-- Bootstrap Core CSS -->
    <link href="{!! asset("assets/plugins/bootstrap/css/bootstrap.min.css") !!}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{!! asset("assets/plugins/chartist-js/dist/chartist.min.css") !!}" rel="stylesheet">
    <link href="{!! asset("assets/plugins/chartist-js/dist/chartist-init.css") !!}" rel="stylesheet">
    <link href="{!! asset("assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css") !!}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{!! asset("assets/plugins/c3-master/c3.min.css") !!}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{!! asset("css/style.css") !!}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{!! asset("css/colors/blue.css") !!}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
@stack('css')
<body class="fix-header fix-sidebar card-no-border">
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper">
    @include('panel.inc.header')
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('cms::panel.login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('cms::panel.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('cms::panel.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ trans('cms::panel.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('cms::panel.login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('panel.inc.footer')
</div>
</body>
<script src="{!! asset("assets/plugins/jquery/jquery.min.js") !!}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{!! asset("assets/plugins/bootstrap/js/tether.min.js") !!}"></script>
<script src="{!! asset("assets/plugins/bootstrap/js/bootstrap.min.js") !!}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{!! asset("js/jquery.slimscroll.js") !!}"></script>
<!--Wave Effects -->
<script src="{!! asset("js/waves.js") !!}"></script>
<!--Menu sidebar -->
<script src="{!! asset("js/sidebarmenu.js") !!}"></script>
<!--stickey kit -->
<script src="{!! asset("assets/plugins/sticky-kit-master/dist/sticky-kit.min.js") !!}"></script>
<!--Custom JavaScript -->
<script src="{!! asset("js/custom.min.js") !!}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!-- chartist chart -->
<script src="{!! asset("assets/plugins/chartist-js/dist/chartist.min.js") !!}"></script>
<script src="{!! asset("assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js") !!}"></script>
<!--c3 JavaScript -->
<script src="{!! asset("assets/plugins/d3/d3.min.js") !!}"></script>
<script src="{!! asset("assets/plugins/c3-master/c3.min.js") !!}"></script>
<!-- Chart JS -->
<script src="{!! asset("js/dashboard1.js") !!}"></script>
@stack('js')
</html>

