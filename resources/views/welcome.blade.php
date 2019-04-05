@extends('layout')

@section('content')
    <h1>My first trial on Laravel 5.7 by {{ $foo }}</h1>

    <h3 class="mt-4 text-center">Tasks</h3>
    <hr>
    <ul>
        @foreach($tasks as $task)
            <li>{{ $task }}</li>
        @endforeach

    </ul>

@endsection