<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Lesson;
use App\Models\Mark;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:teacher', ['except' => ['show']]);
    }

    public function getUsers(Request $request, $course_id, $lesson_id, $project_id){
        $students = User::getUsersOfCourse($course_id, Roles::Student)->get();
        // Search by name
        if($request->search){
            $request->validate([
                'search' => ['regex:/^[a-zA-ZÀ-ÿ\ ]+$/','max:50','min:3']
            ]);

            $students = $students->filter(function($student) use ($request){
                return str_contains(strtolower($student->name), strtolower($request->search));
            });
        }
        // Order by mark
        if($request->order_by == 'mark'){
            if($request->order == 'asc'){
                $students = $students->sortBy(function($student) use ($project_id){
                    $mark = $student->marks->firstWhere('project_id', $project_id);
                    return $mark ? $mark->mark : 0;
                });
            }
            if($request->order == 'desc'){
                $students = $students->sortByDesc(function($student) use ($project_id){
                    $mark = $student->marks->firstWhere('project_id', $project_id);
                    return $mark ? $mark->mark : 0;
                });
            }
        }
        return view('projects.users', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project_id,
            'students' => $students,
        ]);
    }
    
    public function getUserDetails($course_id, $lesson_id, $project_id, $user_id){
        $user = User::findOrFail($user_id);
        $project = Project::findOrFail($project_id);
        // dd($user->uploads);
        return view('projects.user-details', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project' => $project,
            'user' => $user,
        ]);
    }

    public function evaluate(Request $request, $course_id, $lesson_id, $project_id, $user_id){
        request()->validate([
            'mark' => 'required|numeric|min:0|max:20', // Mark from 0 to 20
        ]);

        $user = User::findOrFail($user_id);
        $mark = $user->marks->firstWhere('project_id', $project_id);

        if($mark){
            $mark->mark = round($request->input('mark'), 2);
            $mark->save();
        }else{
            $mark = new Mark();
            $mark->mark = round($request->input('mark'), 2);
            $mark->user()->associate($user_id);
            $mark->project()->associate($project_id);
            $mark->save();
        }
        return back()->with('success', 'Mark updated successfully');
    }

    /* ---------------------------------- CRUD ---------------------------------- */

    public function show($course_id, $lesson_id, $project_id){
        $project = Project::findOrFail($project_id);
        $upload = $project->uploads()->where('user_id', auth()->user()->id)->first();

        // Check if the user is enrolled in the course
        if(auth()->user()->courses->contains($project->lesson->course)){
            return view('projects.show', [
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'project' => $project,
                'upload' => $upload,
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
            'lesson_id' => 'required'
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
        Storage::deleteDirectory('public/uploads/project_'.$project_id);
        return redirect()->route('course_details_page', $course_id)->with('success', 'Project deleted successfully');
    }

}
