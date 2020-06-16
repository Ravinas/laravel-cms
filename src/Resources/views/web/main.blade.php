<!doctype html>
<html lang="{!! $page->detail->language->code !!}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{!! $page->detail->name !!}</title>
        <meta name="description" content="{!! $page->detail->meta->description !!}">
        <meta name="keywords" content="{!! $page->detail->meta->keywords !!}">
        <meta name="author" content="PrimeCMS">
        <meta name="robots" content="{!! ($page->detail->meta->robots ? "index, follow":"noindex, nofollow") !!}">
        <link rel="canonical" href="{!! url()->full() !!}">
        <link rel="icon" type="image/png" sizes="16x16" href="{!! asset("favicon.png") !!}">

        <link href="{!! asset("vendor/cms/assets/plugins/bootstrap/css/bootstrap.min.css") !!}" rel="stylesheet">
    </head>
    @stack('css')

    <body class="@stack('bodyClass')">

    @yield('header')

    @yield('sidebar')

    @yield('content')

    @yield('footer')


    </body>

    <script src="{!! asset("vendor/cms/assets/plugins/jquery/jquery.min.js") !!}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{!! asset("vendor/cms/assets/plugins/bootstrap/js/tether.min.js") !!}"></script>
    <script src="{!! asset("vendor/cms/assets/plugins/bootstrap/js/bootstrap.min.js") !!}"></script>
    @stack('js')
</html>
