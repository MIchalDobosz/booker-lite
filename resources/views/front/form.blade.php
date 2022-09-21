@extends('front.layout')

@section('content')
    <form method="POST">
        @csrf

        <label for="first_name"> Imię: </label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
        @if ($errors->has('first_name'))
            {{ $errors->first('first_name') }}
        @endif
        <br>

        <label for="last_name"> Nazwisko: </label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
        @if ($errors->has('last_name'))
            {{ $errors->first('last_name') }}
        @endif
        <br>

        <label for="email"> Email: </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
            {{ $errors->first('email') }}
        @endif
        <br>
        <br>

        @foreach ($slots as $date => $times)
            <input type="radio" name="date" id="date" value="{{ $date }}">
            <label for="date"> {{ $date }} </label>
            <br>
        @endforeach
        <br>

        @foreach ($slots as $date => $times)
            <select id="{{ $date }}" name="time">
                @foreach ($times as $time)
                    <option value="{{ $time }}"> {{ $time }} </option>
                @endforeach
            </select>
        @endforeach
        <br>

        <input type="submit" value="Zapisz">
    </form>

    <script>
        document.querySelectorAll("select").forEach((select) => select.hidden = true)

        document.querySelectorAll("input[type='radio']").forEach((radio) => radio.addEventListener('click', (event) => {
            document.querySelectorAll("select").forEach((select) => select.hidden = true)
            document.querySelector("[id='" + event.target.value + "']").hidden = false
        }))
    </script>
@endsection


