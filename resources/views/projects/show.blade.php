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
  Link upload
  <form action="{{route('upload_creation', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id,
  ])}}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="upload_file[]" placeholder="Upload file">
    <br>

    {{-- {{dd($uploads);}} --}}
    @foreach ($uploads as $upload)
      @foreach ($upload->links as $link)
        <input type="text" name="upload_link[]" placeholder="Upload link" value="{{$link->link}}">
      @endforeach
    @endforeach
    <br>
    <input type="text" name="upload_link[]" placeholder="Upload link">
    {{-- <input type="text" name="upload_link[]" placeholder="Upload link">
    <input type="text" name="upload_link[]" placeholder="Upload link"> --}}
    <br>
    <button type="submit">Upload</button>
  </form>

  {{-- Uploaded photo --}}
  {{-- @foreach ($project->uploads as $upload)
    @foreach ($upload->files as $file)
      <div>
        <img src="{{asset($file->file_url)}}" alt="Uploaded photo">
      </div>
    @endforeach
  @endforeach --}}

@endsection