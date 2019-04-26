<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Project;
use App\Mail\ProjectCreated;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    public function index()
    {
//        dd(auth()->id());
//          $projects = auth()->user()->projects;
//        $projects = Project::where('owner_id',auth()->id())->get();

        return view('projects.index',[
            'projects' => auth()->user()->projects
        ]);
    }
    public function show(Project $project)
    {

        $this->authorize('update', $project);
//        abort_if ($project->owner_id !== auth()->id(), 403);
        return view('projects.show', compact('project'));
    }
    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $validated = $this->validateProject();
//        dd(auth()->id());
        $validated['owner_id'] = auth()->id();
//        dd($validated);
        $project = Project::create($validated);
//        Project::create([
//            'title' => request('title'),
//            'description' => request('description')
//        ]);

        event(new ProjectCreated($project));
        session()->flash('message','Project has been created');
        return redirect('projects');
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    public function update(Project $project)
    {
//        $validated = request()->validate([
//            'title' => ['required','min:3','max:255'],
//            'description' => ['required','min:3'],
//        ]);
        $project->update($this->validateProject());
//
//        $project->title = request('title');
//        $project->description = request('description');
//
//        $project->save();

        return redirect('/projects');
    }
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/projects');
    }

    public function validateProject()
    {
        return request()->validate([
            'title' => ['required','min:3','max:255'],
            'description' => ['required','min:3'],
        ]);
    }
}
