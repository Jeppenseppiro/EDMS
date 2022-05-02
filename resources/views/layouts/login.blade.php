<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>EDMS | @yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{asset('edms.png')}}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <link rel="stylesheet" href="{{ url('fontawesome6/css/all.css') }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/addons-pro/timeline.css') }}" rel="stylesheet">
        <link href="{{ asset('css/addons-pro/timeline.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/mdb.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/addons-pro/timeline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}" type="text/javascript"></script>
</html>

