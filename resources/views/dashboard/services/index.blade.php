@extends('dashboard.layout')

@section('content')
    <table>
        <tr>
            <th> Nazwa </th>
            <th> Czas trwania </th>
            <th> Cena </th>
            <th> Dostępna </th>
        </tr>
        @foreach ($services as $service)
        <tr>
            <td> {{ $service->name }} </td>
            <td> {{ $service->duration }} </td>
            <td> {{ $service->price }} </td>
            <td> {{ $service->is_available ? 'Tak' : 'Nie' }} </td>
        </tr>
        @endforeach
    </table>
@endsection
