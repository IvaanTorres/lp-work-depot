@extends('base')

@section('content')
  <h1>Students for this project</h1>
  <ul>
    @foreach ($students as $student)
      <li>
        <p>{{$student->name}}</p>

        <a href="{{route('project_user_details_page', [
          'course_id' => $course_id,
          'lesson_id' => $lesson_id,
          'project_id' => $project_id,
          'user_id' => $student->id,
        ])}}">See uploads</a>

        {{-- When student has already a mark --}}
        <div>
          <form action="{{route('project_evaluate', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project_id,
            'user_id' => $student->id,
          ])}}" method="POST">
            @csrf
            @method('PUT')

            <input type="number" name="mark" step="0.00001" value="{{$student->marks->firstWhere('project_id', $project_id)->mark ?? ''}}">

            {{-- Errors --}}
            @if ($errors->any())
              <div>{{ $errors->first() }}</div>
            @endif

            <button type="submit">Update mark</button>
          </form>
        </div>
      </li>
    @endforeach
  </ul>
@endsection