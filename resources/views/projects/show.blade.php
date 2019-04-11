@extends('layout')
@section('title')
    {{ $project->title }}
@endsection

@section('content')
    <h1 class="title">{{ $project->title  }}</h1>
    <p>{{ $project->description  }}</p>
    <a href="/projects/{{ $project->id }}/edit" class="btn btn-outline-primary btn-sm">Edit Project</a>

    @if($project->tasks->count())
        <div class="box">
            <h2 class="text-center">Project's Tasks</h2>
            <hr>
            @foreach($project->tasks as $task)
                <form method="POST" action="/tasks/{{ $task->id }}">
                    @method('PATCH')
                    @csrf
                    <div>
                        <label class="checlbox {{ $task->completed ? 'is-comlete':'' }}" for="completed">
                            <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked':'E' }}>
                            {{ $task->description }}
                        </label>
                    </div>
                </form>
            @endforeach
        </div>
    @endif

    {{--add a task--}}
    <h1 class="text-center">Add a Task</h1>
    <form method="POST" action="/projects/{{ $project->id }}/tasks" class="box">
        @csrf
        <div class="field">
            <label class="label" for="title">New Task</label>

            <div class="control">
                <input type="text" class="input {{ $errors->has('description') ? 'is-danger': '' }}"  name="description" placeholder="description" value=" {{ old('description') }}">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link purple">Add Task</button>

            </div>
        </div>
        @include('errors')
    </form>


@endsection

