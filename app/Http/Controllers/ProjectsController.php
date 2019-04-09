<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }
    public function show()
    {

    }
    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $project = new Project();
        $project->title = request('title');
        $project->description = request('description');
        $project->save();

        return redirect('projects');
    }
    public function edit($id)
    {
//        return $id;
        $project = Project::findOrFail($id);
//        dd($project);
        return view('projects.edit', compact('project'));
    }
    public function update($id)
    {

        $project = Project::findOrFail($id);
        $project->title = request('title');
        $project->description = request('description');

        $project->save();

        return redirect('/projects');
    }
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return redirect('/projects');
    }
}
