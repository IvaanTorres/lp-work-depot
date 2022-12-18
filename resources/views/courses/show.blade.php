@extends('base')

@section('content')
  <h1>{{$course->title}}</h1>
  <p>{{$course->description}}</p>

  <h2>Lessons (Asignaturas)</h2>
  <ul>
    @foreach ($course->lessons as $lesson)
      <li>
        <a href="{{ route('lesson_details_page', [
          'course_id' => $course->id,
          'lesson_id' => $lesson->id
        ]) }}">
          {{ $lesson->title }}
        </a>
        <ul>
          @foreach ($lesson->projects as $project)
            <li>
              <a href="{{ route('project_details_page', [
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'project_id' => $project->id
              ]) }}">
                {{ $project->title }}
              </a>
            </li>
          @endforeach
        </ul>
      </li>
    @endforeach
  </ul>

@endsection