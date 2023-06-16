@extends('front.layout')

@section('content')
    Pracownik:
    <br>
    <a href="{{ route('reservation-form', [$service->id]) }}"> Dowolny </a>
    <br>
    @foreach ($employees as $employee)
        <a href="{{ route('reservation-form-employee', [$service->id, $employee->id]) }}"> {{ $employee->first_name . ' ' . $employee->last_name }} </a>
        <br>
    @endforeach
    <br>

    <form method="POST" action="{{ route('reservation-store', [$service->id]) }}">
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
                @foreach ($times as $time => $timeEmployees)
                    <option value="{{ $time }}"> {{ $time }} </option>
                @endforeach
            </select>
        @endforeach
        <br>
        <br>

        @foreach ($slots as $date => $times)
                @foreach ($times as $time => $timeEmployees)
                    <select id="{{ $date . ' ' . $time }}" name="employee_id">
                    @foreach ($timeEmployees as $employeeId)
                        <option value="{{ $employeeId }}"> {{ $employees->get($employeeId)?->getFullName() }} </option>
                    @endforeach
                    </select>
                @endforeach
        @endforeach
        <br>
        <br>

        <input type="submit" value="Zapisz">
    </form>

    <script>
        document.querySelectorAll("select").forEach((select) => {
            select.disabled = true
            select.hidden = true
        })

        document.querySelectorAll("input[type='radio']").forEach((radio) => radio.addEventListener('click', (event) => {
            document.querySelectorAll("select").forEach((select) => {
                select.disabled = true
                select.hidden = true
            })

            const timeInput = document.querySelector("[id='" + event.target.value + "']")
            timeInput.disabled = false
            timeInput.hidden = false

            const employeeInput = document.querySelector("[id='" + timeInput.id + " " + timeInput.value + "']")
            employeeInput.disabled = false
            employeeInput.hidden = false
        }))

        document.querySelectorAll("select[name='time']").forEach((select) => select.addEventListener('change', (event) => {
            document.querySelectorAll("select[name='employee_id']").forEach((select) => {
                select.disabled = true
                select.hidden = true
            })

            const employeeInput = document.querySelector("[id='" + event.target.id + " " + event.target.value + "']")
            employeeInput.disabled = false
            employeeInput.hidden = false
        }))
    </script>
@endsection


