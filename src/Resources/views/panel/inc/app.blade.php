<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{!! asset("vendor/cms/assets/images/favicon.png") !!}">
        <title>PRIME ALPHA</title>
        <!-- Bootstrap Core CSS -->
        <link href="{!! asset("vendor/cms/assets/plugins/bootstrap/css/bootstrap.min.css") !!}" rel="stylesheet">
        <!-- chartist CSS -->
        <link href="{!! asset("vendor/cms/assets/plugins/chartist-js/dist/chartist.min.css") !!}" rel="stylesheet">
        <link href="{!! asset("vendor/cms/assets/plugins/chartist-js/dist/chartist-init.css") !!}" rel="stylesheet">
        <link href="{!! asset("vendor/cms/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css") !!}" rel="stylesheet">
        <!--This page css - Morris CSS -->
        <link href="{!! asset("vendor/cms/assets/plugins/c3-master/c3.min.css") !!}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{!! asset("vendor/cms/css/style.css") !!}" rel="stylesheet">
        <!-- You can change the theme colors from here -->
        <link href="{!! asset("vendor/cms/css/colors/blue.css") !!}" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]-->
{{--        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>--}}
{{--        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}
        <!--[endif]-->
        @stack('css')
    </head>
    <body class="fix-header fix-sidebar card-no-border">
        <div id="main-wrapper">
            @include('cms::panel.inc.header')
            @include('cms::panel.inc.sidebar')
            @yield('content')
            @include('cms::panel.inc.footer')
        </div>
    </body>
    <script src="{!! asset("vendor/cms/assets/plugins/jquery/jquery.min.js") !!}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{!! asset("vendor/cms/assets/plugins/bootstrap/js/tether.min.js") !!}"></script>
    <script src="{!! asset("vendor/cms/assets/plugins/bootstrap/js/bootstrap.min.js") !!}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{!! asset("vendor/cms/js/jquery.slimscroll.js") !!}"></script>
    <!--Wave Effects -->
    <script src="{!! asset("vendor/cms/js/waves.js") !!}"></script>
    <!--Menu sidebar -->
    <script src="{!! asset("vendor/cms/js/sidebarmenu.js") !!}"></script>
    <!--stickey kit -->
    <script src="{!! asset("vendor/cms/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js") !!}"></script>
    <!--Custom JavaScript -->
    <script src="{!! asset("vendor/cms/js/custom.min.js") !!}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="{!! asset("vendor/cms/assets/plugins/chartist-js/dist/chartist.min.js") !!}"></script>
    <!--c3 JavaScript -->
    <script src="{!! asset("vendor/cms/assets/plugins/d3/d3.min.js") !!}"></script>
    <script src="{!! asset("vendor/cms/assets/plugins/c3-master/c3.min.js") !!}"></script>
    <!-- Chart JS -->
    <script src="{!! asset("vendor/cms/js/dashboard1.js") !!}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-165733470-1"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-165733470-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-165733470-1');
</script>

    @stack('js')
</html>
