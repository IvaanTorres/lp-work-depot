<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:teacher');
    }

    public function show($course_id, $lesson_id, $project_id){
        $project = Project::findOrFail($project_id);

        // Check if the user is enrolled in the course
        if(auth()->user()->courses->contains($project->lesson->course)){
            return view('projects.show', [
                'project' => $project,
            ]);
        }else{
            return back()->with('error', 'You are not enrolled in this course');
        }
    }
}
