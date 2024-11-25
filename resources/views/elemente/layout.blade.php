<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('imagini/kiraracat.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title> @yield('titlu') | {{ config('app.name') }}</title>
</head>
<body>
    @include('elemente.header')
    @include('elemente.menu')
    @yield('continut')
    @include('elemente.footer')
</body>
</html>

<style>
    html {
        height: 100%;
    }

    body {
        min-height: 98.93%;
        display: flex;
        flex-direction: column
    }
</style>