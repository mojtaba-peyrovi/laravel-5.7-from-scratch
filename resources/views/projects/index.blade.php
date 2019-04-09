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
                <h4>{{ $project->title }}</h4>
                <p>
                    {{$project->description}}
                </p>
            </li>
            <hr>
        @endforeach

    </ul>
@endsection

