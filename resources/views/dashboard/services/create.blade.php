@extends('dashboard.layout')

@section('content')
    <form method="post">
        @csrf

        <label for="name"> Nazwa: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @if ($errors->has('name'))
            {{ $errors->first('name') }}
        @endif
        <br>

        <label for="duration"> Czas trwania: </label>
        <select name="duration" id="duration">
            @foreach ($durationOptions as $durationOption)
                <option @if(old('duration') === $durationOption) selected @endif value="{{ $durationOption }}"> {{ $durationOption }} </option>
            @endforeach
        </select>
        <br>

        <label for="price"> Cena: </label>
        <input type="number" name="price" id="price" min="0.00" step="0.01" value="{{ old('price') ?? '0.00' }}">
        @if ($errors->has('price'))
            {{ $errors->first('price') }}
        @endif
        <br>

        <label for="is_available"> Dostępny: </label>
        <input type="checkbox" name="is_available" id="is_available" value='1' @if(old('is_available')) checked @endif>
        @if ($errors->has('is_available'))
            {{ $errors->first('is_available') }}
        @endif
        <br>
        <br>
        Pracownicy:
        <br>
        @foreach ($employeeList as $id => $name)
            <input type="checkbox" name="employee_list[{{ $id }}]" id="employee_list-{{ $id }}" value='1' @if(old('employee_list.' . $id) === '1') checked @endif>
            <label for="employee_list-{{ $id }}"> {{ $name }} </label>
            @if ($errors->has('employee_list.' . $id))
                {{ $errors->first('employee_list.' . $id) }}
            @endif
            <br>
        @endforeach
        <br>

        <input type="submit" value="Zapisz">
    </form>
@endsection
