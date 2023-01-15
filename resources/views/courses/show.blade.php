@extends('base')

@section('content')
  <h1>{{$course->title}}</h1>
  <p>{{$course->description}}</p>
  
  {{-- Just teacher --}}
  @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
    <form action="{{route('course_deletion', ['course_id' => $course->id])}}" method="POST">
      @csrf
      @method('DELETE')
      <input type="hidden" name="course_id" value="{{$course->id}}">
      <button type="submit">Delete</button>
    </form>
    <a href="{{route('course_modification_page', ['course_id' => $course->id])}}">Edit</a>
    <br>
    <a href="{{route('course_users_page', [
      'course_id' => $course->id,
    ])}}">Link users</a>
  @endif
  
  {{-- Lessons --}}
  <h2>Lessons (Asignaturas)</h2>
  <ul>
    @foreach ($course->lessons as $lesson)
      <li>
        <div>
          <p>{{ $lesson->title }}</p>
          <p>{{ $lesson->description }}</p>

          {{-- Just teacher --}}
          @if(Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
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
            <a href="{{ route('project_creation_page', [
              'course_id' => $course->id,
              'lesson_id' => $lesson->id
            ]) }}">Create Project</a>
          @endif
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
              
              {{-- Just teacher --}}
              @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
                <a href="{{ route('project_modification_page', [
                  'course_id' => $course->id,
                  'lesson_id' => $lesson->id,
                  'project_id' => $project->id
                ]) }}">Edit</a>
                <form action="{{ route('project_deletion', [
                  'course_id' => $course->id,
                  'lesson_id' => $lesson->id,
                  'project_id' => $project->id
                ]) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="project_id" value="{{ $project->id }}">
                  <button type="submit">Delete</button>
                </form>
              @endif
            </li>
          @endforeach
        </ul>
      </li>
    @endforeach
  </ul>

@endsection