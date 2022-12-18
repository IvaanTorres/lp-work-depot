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
}
