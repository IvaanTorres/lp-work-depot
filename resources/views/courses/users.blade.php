@extends('base')

@section('content')
  <h1>Students linked to this course</h1>
  <ul>
    @foreach ($students as $student)
      <li>
        <p>
          {{$student->name}} 
          <form action="{{route('course_unlink_users', [
            'course_id' => $course_id,
            'user_id' => $student->id
          ])}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{$student->id}}">
            <button type="submit">Unlink</button>
          </form>
        </p>
      </li>
    @endforeach
  </ul>
  {{-- Add user --}}
  <form action="{{route('course_link_users', ['course_id' => $course_id])}}" method="POST">
    @csrf
    <input type="hidden" name="course_id" value="{{$course_id}}">
    <input type="text" name="user_email" placeholder="User email">
    <button type="submit">Link user</button>
  </form>
@endsection