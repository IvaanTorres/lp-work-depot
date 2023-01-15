@extends('base')

@section('content')
  {{-- Create edit project form --}}
  <form action="{{route('project_modification', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id
  ])}}" method="POST">
    @csrf
    @method('PUT')

    {{-- Errors --}}
    @if ($errors->any())
      <div>{{ $errors->first() }}</div>
    @endif
    
    <input type="hidden" name="lesson_id" value="{{$lesson_id}}">
    <input type="text" name="title" placeholder="Title" value="{{$project->title}}">
    <input type="text" name="description" placeholder="Description" value="{{$project->description}}">
    <button type="submit">Edit</button>
  </form>
@endsection