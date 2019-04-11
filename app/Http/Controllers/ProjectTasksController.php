<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;
class ProjectTasksController extends Controller
{

    public function update(Task $task)
    {
//        $task->complete();
//        $task->update([
//            'completed' => request()->has('completed')
//        ]);

          $method = request()->has('completed') ? 'complete' : 'incomplete';
          $task->$method();
        return back();
    }

    public function store(Project $project)
    {
        $attr = request()->validate(['description' => 'required']);
        $project->addTask($attr);

        return back();
    }
}
