<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('front.partials.head')
<body>
@include('front.partials.message')
@yield('content')
</body>
</html>
