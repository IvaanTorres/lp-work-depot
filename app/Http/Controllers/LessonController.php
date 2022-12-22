<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:teacher');
    }

    public function create($course_id){
        return view('lessons.create', [
            'course_id' => $course_id,
        ]);
    }

    public function store(Request $request, $course_id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $course = Course::find($course_id);
        $lesson = $course->lessons()->create($request->all());
        foreach(array_filter($request->input('project-title')) as $key => $value){
            $lesson->projects()->create([
                'title' => $value,
                'description' => $request->input('project-description')[$key],
            ]);
        }
        return redirect()->route('course_details_page', $course->id)->with('success', 'Lesson created successfully');
    }

    public function edit($course_id, $lesson_id){
        $lesson = Lesson::find($lesson_id);
        return view('lessons.edit', [
            'course' => $lesson->course,
            'lesson' => $lesson,
        ]);
    }

    public function update(Request $request, $course_id, $lesson_id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $lesson = Lesson::find($lesson_id);
        $lesson->update($request->all());
        return redirect()->route('course_details_page', $lesson->course->id)->with('success', 'Lesson updated successfully');
    }

    public function destroy($course_id, $lesson_id){
        $lesson = Lesson::find($lesson_id);
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully');
    }

}
