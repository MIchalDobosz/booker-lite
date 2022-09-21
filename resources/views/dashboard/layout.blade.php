<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('dashboard.partials.head')
<body>
@include('dashboard.partials.message')
@yield('content')
</body>
</html>
