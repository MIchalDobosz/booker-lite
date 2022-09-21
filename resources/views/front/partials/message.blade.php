@if (session()->has('message'))
    {{ session()->get('message') }}
@endif
