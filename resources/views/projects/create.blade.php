@extends('layout');
@section('title')
    Create a Project
@endsection
@section('content')
<h1>Create A Project</h1>
<hr>
<form method="POST" action="/projects">
    {{ csrf_field() }}

    <div class="field">
        <label class="label" for="title">Title</label>

        <div class="control">
            <input type="text" class="input {{ $errors->has('title') ? 'is-danger': '' }}"  name="title" placeholder="Title" value=" {{ old('title') }}">
        </div>
    </div>

    <div class="field">
        <label class="label" for="description">Description</label>

        <div class="control">
            <textarea name="description" class="textarea {{ $errors->has('description') ? 'is-danger': '' }}">{{ old('description')  }}</textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link">Create Porject</button>

        </div>
    </div>
    @include('errors')
</form>
@endsection
