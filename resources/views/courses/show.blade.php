@extends('base')

@section('content')
  <h1>{{$course->title}}</h1>
  <p>{{$course->description}}</p>
  <form action="{{route('course_deletion', ['course_id' => $course->id])}}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="course_id" value="{{$course->id}}">
    <button type="submit">Delete</button>
  </form>
  <a href="{{route('course_modification_page', ['course_id' => $course->id])}}">Edit</a>
  
  {{-- Lessons --}}
  <h2>Lessons (Asignaturas)</h2>
  <ul>
    @foreach ($course->lessons as $lesson)
      <li>
        <div>
          {{ $lesson->title }}
          <form action="{{route('lesson_deletion', [
            'course_id' => $course->id,
            'lesson_id' => $lesson->id
          ])}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
            <button type="submit">Delete</button>
          </form>
          <a href="{{ route('lesson_modification_page', [
            'course_id' => $course->id,
            'lesson_id' => $lesson->id
          ]) }}">Edit</a>
          <a href="{{ route('lesson_creation_page', [
            'course_id' => $course->id,
          ]) }}">Create Project</a>
        </div>
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