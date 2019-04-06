@extends('layout');
@section('title')
    Create a Project
@endsection
@section('content')
<h1>Create A Project</h1>
<hr>
<form method="POST" action="/projects">
    {{ csrf_field() }}
    <div>
        <input type="text" name="title" placeholder="project title">
    </div>
    <div>
        <textarea name="description" placeholder="project description"></textarea>
    </div>
    <div>
        <button type="submit">Create Project</button>
    </div>
</form>
@endsection
