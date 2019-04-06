@extends('layout')

@section('title')
Projects
@endsection

@section('content')
    <h1>All projects</h1>
    <h3 class="mt-4 text-center">Projects</h3>
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

