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
            return view('courses.show', compact('course'));
        }else{
            return back()->with('error', 'You are not enrolled in this course');
        }
    }
}
