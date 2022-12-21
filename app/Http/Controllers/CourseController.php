<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:teacher');
    }

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
            'title' => 'required',
            'description' => 'required',
            'lesson-title' => 'required',
            'lesson-description' => 'required',
        ]);

        $course = Course::create($request->all());
        $course->users()->attach(auth()->user()->id);
        foreach($request->input('lesson-title') as $key => $value){
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
            'title' => 'required',
            'description' => 'required',
        ]);

        $course = Course::find($course_id);
        $course->update($request->all());

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
