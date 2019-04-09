@extends('layout')
@section('title')
    {{ $project->title }}
@endsection

@section('content')
    <h1 class="title">{{ $project->title  }}</h1>
    <p>{{ $project->description  }}</p>

    <a href="/projects/{{ $project->id }}/edit" class="btn btn-outline-primary btn-sm">Edit Project</a>
@endsection

