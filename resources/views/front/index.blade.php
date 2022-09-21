@extends('front.layout')

@section('content')
    @foreach ($services as $k => $v)
        <a href="{{ route('reservation-form', [$k]) }}"> {{ $v }} </a>
        <br>
    @endforeach
@endsection
