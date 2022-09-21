@extends('dashboard.layout')

@section('content')
    <form method="post">
        @csrf

        <label for="name"> Nazwa: </label>
        <input type="text" name="name" id="name" value="{{ $service->name }}">
        @if ($errors->has('name'))
            {{ $errors->first('name') }}
        @endif
        <br>

        <label for="duration"> Czas trwania: </label>
        <select name="duration" id="duration">
            @foreach ($durationOptions as $durationOption)
                <option @if($service->duration === $durationOption) selected @endif value="{{ $durationOption }}"> {{ $durationOption }} </option>
            @endforeach
        </select>
        <br>

        <label for="price"> Cena: </label>
        <input type="number" name="price" id="price" min="0.00" step="0.01" value="{{ $service->price }}">
        @if ($errors->has('price'))
            {{ $errors->first('price') }}
        @endif
        <br>

        <label for="is_available"> Dostępny: </label>
        <input type="checkbox" name="is_available" id="is_available" value='1' @if($service->is_available) checked @endif>
        @if ($errors->has('is_available'))
            {{ $errors->first('is_available') }}
        @endif
        <br>

        <input type="submit" value="Zapisz">
    </form>
@endsection
