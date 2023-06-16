@extends('dashboard.layout')

@section('content')
    <table>
        <tr>
            <th> Imię </th>
            <th> Nazwisko </th>
        </tr>
        @foreach ($employees as $employee)
        <tr>
            <td> {{ $employee->first_name }} </td>
            <td> {{ $employee->last_name }} </td>
        </tr>
        @endforeach
    </table>
@endsection
