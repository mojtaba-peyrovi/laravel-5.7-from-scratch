<?php

namespace App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Mail\ProjectCreated;
class Project extends Model
{
    protected $guarded=[];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {
//        return Task::create([
//            'project_id' => $this->id,
//            'description' => $description
//        ]);
        $this->tasks()->create($task);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}

