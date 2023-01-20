<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:teacher', ['except' => ['index', 'show']]);
    }

    public function getUsers(Request $request, $course_id){
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

        return view('courses.users', [
            'course_id' => $course_id,
            'students' => $students,
        ]);
    }

    public function linkUser(Request $request, $course_id){
        $request->validate([
            'user_email' => 'required|email|exists:users,email',
        ]);

        $course = Course::findOrFail($course_id);
        $user = User::where('email', $request->input('user_email'))->first();

        // Check if the user is already enrolled in the course
        if($course->users->contains($user)){
            return redirect()->back()->withErrors(['alreadyEnrolled' => 'User is already enrolled in this course']);
        }else{
            $course->users()->attach($user);
            return redirect()->back()->with('success', 'User linked successfully');
        }
    }

    public function unlinkUser($course_id, $user_id){
        $course = Course::findOrFail($course_id);
        $user = User::findOrFail($user_id);
        $course->users()->detach($user);

        return redirect()->route('course_users_page', $course_id)->with('success', 'User unlinked successfully');
    }

    /* ---------------------------------- CRUD ---------------------------------- */

    public function index(){
        // Fetch all courses which are linked to the user from the database
        $courses = auth()->user()->courses;
        return view('courses.index', compact('courses'));
    }

    public function show($course_id){
        $course = Course::find($course_id);

        // Check if the user is enrolled in the course
        if(auth()->user()->courses->contains($course)){
            return view('courses.show', [
                'course' => $course,
            ]);
        }else{
            return back()->with('error', 'You are not enrolled in this course');
        }
    }

    public function create(){
        return view('courses.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'lesson-title' => 'required|array',
            'lesson-title.*' => 'nullable|string',
            'lesson-description' => 'required|array',
            'lesson-description.*' => 'nullable|required_with:lesson-title.*|string', // lesson-description.* is required if lesson-title.* is not null
        ]);

        $course = Course::create($request->all());
        $course->users()->attach(auth()->user()->id);
        foreach(array_filter($request->input('lesson-title')) as $key => $value){
            $course->lessons()->create([
                'title' => $value,
                'description' => $request->input('lesson-description')[$key],
            ]);
        }

        return redirect()->route('course_details_page', $course->id)->with('success', 'Course created successfully');
    }

    public function edit($course_id){
        $course = Course::find($course_id);

        // Check if the user is the owner of the course
        if($course->getTeacherById(auth()->user()->id)){
            return view('courses.edit', [
                'course' => $course,
            ]);
        }else{
            return back()->with('error', 'You are not the owner of this course');
        }
    }

    public function update(Request $request, $course_id){
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'lesson-title' => 'required|array',
            'lesson-title.*' => 'nullable|string',
            'lesson-description' => 'required|array',
            'lesson-description.*' => 'nullable|required_with:lesson-title.*|string', // lesson-description.* is required if lesson-title.* is not null
        ]);

        $course = Course::find($course_id);
        $course->update($request->all());
        $course->lessons()->delete();
        foreach(array_filter($request->input('lesson-title')) as $key => $value){
            $course->lessons()->create([
                'title' => $value,
                'description' => $request->input('lesson-description')[$key],
            ]);
        }

        return redirect()->route('course_details_page', $course->id)->with('success', 'Course updated successfully');
    }

    public function destroy($course_id){
        $course = Course::find($course_id);

        // Check if the teacher is the owner of the course
        if($course->getTeacherById(auth()->user()->id)){
            $course->delete();
            return redirect()->route('courses_list_page')->with('success', 'Course deleted successfully');
        }else{
            return back()->with('error', 'You are not the owner of this course');
        }
    }
}
