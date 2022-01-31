<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    </head>
    <body>
        @yield('content')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js'></script>
    <script  src="{{ asset('public/js/script.js') }}"></script>
</body>
</html>