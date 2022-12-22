@extends('base')

@section('content')
  {{-- Cretae project form --}}
  <form action="{{route('project_creation', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id
  ])}}" method="POST">
    @csrf
    <input type="hidden" name="lesson_id" value="{{$lesson_id}}">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="description" placeholder="Description">
    <button type="submit">Create</button>
  </form>
@endsection