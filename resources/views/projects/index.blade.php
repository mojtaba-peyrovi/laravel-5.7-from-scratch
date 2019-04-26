@extends('layout')

@section('title')
Projects
@endsection

@section('content')
    <h1 class="title text-center">All projects</h1>
    <hr>
    <ul>
        @foreach($projects as $project)
            <li>
                <a href="/projects/{{ $project->id }}">
                <h4>{{ $project->title }}</h4>
                </a>

            </li>
            <hr>
        @endforeach
    @if(session('message'))
        <p>{{ session('messsage') }}</p>
    @endif
    </ul>
@endsection

