@extends('dashboard.layout')

@section('content')
    <form method="post">
        @csrf

        <label for="first_name"> Imię: </label>
        <input type="text" name="first_name" id="first_name" value="{{ $employee->first_name }}">
        @if ($errors->has('first_name'))
            {{ $errors->first('first_name') }}
        @endif
        <br>

        <label for="last_name"> Nazwisko: </label>
        <input type="text" name="last_name" id="last_name" value="{{ $employee->last_name }}">
        @if ($errors->has('last_name'))
            {{ $errors->first('last_name') }}
        @endif
        <br>
        <br>
        Usługi:
        <br>
        @foreach ($serviceList as $id => $name)
            <input type="checkbox" name="service_list[{{ $id }}]" id="service_list-{{ $id }}" value='1' @if($employee->services->contains('id', $id)) checked @endif>
            <label for="service_list-{{ $id }}"> {{ $name }} </label>
            @if ($errors->has('service_list.' . $id))
                {{ $errors->first('service_list.' . $id) }}
            @endif
            <br>
        @endforeach
        <br>

        <input type="submit" value="Zapisz">
    </form>
@endsection
