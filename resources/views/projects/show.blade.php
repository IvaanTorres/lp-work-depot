@extends('base')

@section('content')
  <h1>{{$project->title}} (Proyecto)</h1>
  <p>{{$project->description}}</p>
  <form action="{{route('project_deletion', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id
  ])}}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="project_id" value="{{$project->id}}">
    <button type="submit">Delete</button>
  </form>
  <a href="{{route('project_modification_page', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id
  ])}}">Edit</a>
  <hr>
  <a href="{{route('project_users_page', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id
  ])}}">See users</a>
  <hr>
  <h2>Uploads</h2>
  <p>Aqui es donde tengo que hacer el drag and drop the los upload</p>

@endsection