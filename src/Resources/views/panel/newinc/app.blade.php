<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRIME CMS</title>

    <link rel="stylesheet" href="{!! asset('vendor/cms/yeni/css/bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/cms/yeni/vendors/perfect-scrollbar/perfect-scrollbar.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/cms/yeni/css/app.css') !!}">
    <link rel="shortcut icon" href="{!! asset('vendor/cms/yeni/images/favicon.svg') !!}" type="image/x-icon">
    @stack('css')
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            @include('cms::panel.newinc.sidebar')
        </div>
        <div id="main">
            @include('cms::panel.newinc.header')
            @yield('content')
            @include('cms::panel.newinc.footer')
        </div>
    </div>
    <script src="{!! asset('vendor/cms/yeni/js/feather-icons/feather.min.js') !!}"></script>
    <script src="{!!  asset('vendor/cms/yeni/vendors/perfect-scrollbar/perfect-scrollbar.min.js') !!}"></script>
    <script src="{!!  asset('vendor/cms/yeni/js/app.js"') !!}"></script>
    <script src="{!!  asset('vendor/cms/yeni/js/main.js"') !!}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @stack('js')
</body>
</html>
