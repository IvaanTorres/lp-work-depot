<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Course;
use App\Models\Role;
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
        // Search by name
        if($request->search){
            $request->validate([
                'search' => ['regex:/^[a-zA-ZÀ-ÿ\ ]+$/','max:50','min:1']
            ]);

            $students = User::getUsersOfCourse($course_id, Roles::Student)
                ->where('name', 'like', '%'.$request->search.'%')
                ->get();
        }else{
            $students = User::getUsersOfCourse($course_id, Roles::Student)->get();
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
            return redirect()->back()->with('user_link_info', 'User linked successfully');
        }
    }

    public function unlinkUser($course_id, $user_id){
        $course = Course::findOrFail($course_id);
        $user = User::findOrFail($user_id);
        $course->users()->detach($user);

        return redirect()->route('course_users_page', $course_id)->with('user_unlink_info', 'User unlinked successfully');
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
            'lesson-title.*' => 'nullable|required_with:lesson-description.*|string',
            'lesson-description' => 'required|array',
            'lesson-description.*' => 'nullable|string', // lesson-description.* is required if lesson-title.* is not null
        ]);

        $course = Course::create($request->all());
        $course->users()->attach(auth()->user()->id);
        foreach(array_filter($request->input('lesson-title')) as $key => $value){
            $course->lessons()->create([
                'title' => $value,
                'description' => $request->input('lesson-description')[$key],
            ]);
        }

        return redirect()->route('course_details_page', $course->id)->with('course_create_info', 'Course created successfully');
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
            'lesson-title.*' => 'nullable|required_with:lesson-description.*|string',
            'lesson-description' => 'required|array',
            'lesson-description.*' => 'nullable|string',
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

        return redirect()->route('course_details_page', $course->id)->with('course_update_info', 'Course updated successfully');
    }

    public function destroy($course_id){
        $course = Course::find($course_id);

        // Check if the teacher is the owner of the course
        if($course->getTeacherById(auth()->user()->id)){
            $course->delete();
            return redirect()->route('courses_list_page')->with('course_delete_info', 'Course deleted successfully');
        }else{
            return back()->with('error', 'You are not the owner of this course');
        }
    }
}
