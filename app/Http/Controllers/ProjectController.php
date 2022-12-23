<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Lesson;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:teacher');
    }

    public function getUsers($course_id, $lesson_id, $project_id){
        $students = User::getUsersOfCourse($course_id, Roles::Student)->get();
        return view('projects.users', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project_id,
            'students' => $students,
        ]);
    }

    /* ---------------------------------- CRUD ---------------------------------- */

    public function show($course_id, $lesson_id, $project_id){
        $project = Project::findOrFail($project_id);

        // Check if the user is enrolled in the course
        if(auth()->user()->courses->contains($project->lesson->course)){
            return view('projects.show', [
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'project' => $project,
            ]);
        }else{
            return back()->with('error', 'You are not enrolled in this course');
        }
    }

    public function create($course_id, $lesson_id){
        return view('projects.create', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
        ]);
    }

    public function store(Request $request, $course_id, $lesson_id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'lesson_id' => 'required'
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->lesson()->associate($lesson_id);
        $project->save();

        return redirect()->route('project_details_page', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
        ])->with('success', 'Project created successfully');
    }

    public function edit($course_id, $lesson_id, $project_id){
        $project = Project::findOrFail($project_id);
        return view('projects.edit', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project' => $project,
        ]);
    }

    public function update(Request $request, $course_id, $lesson_id, $project_id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $project = Project::findOrFail($project_id);
        $project->update($request->all());
        return redirect()->route('project_details_page', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
        ])->with('success', 'Project updated successfully');
    }

    public function destroy($course_id, $lesson_id, $project_id){
        $project = Project::findOrFail($project_id);
        $project->delete();
        return redirect()->route('course_details_page', $course_id)->with('success', 'Project deleted successfully');
    }

}
