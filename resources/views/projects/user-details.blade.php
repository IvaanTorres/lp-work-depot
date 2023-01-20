@extends('base')

@section('title', 'Upload Details Of The Student')

@section('content')
  <h1>{{$project->title}} (Proyecto)</h1>
  <p>{{$project->description}}</p>
  <hr>
  <h2>Mark</h2>
  <p>User: {{$user->name}}</p>
  <p>Email: {{$user->email}}</p>
  <p>Mark:</p>
  <form action="{{route('project_evaluate', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id,
    'project_id' => $project->id,
    'user_id' => $user->id,
  ])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="number" name="mark" value="{{$user->marks->firstWhere('project_id', $project->id)->mark ?? ''}}">
    <button type="submit">Update mark</button>
  </form>
  
  <h2>Uploads</h2>
  {{-- Uploaded files and links --}}
  {{-- Files --}}
  @forelse ($user->uploads as $upload)
    <h4>Files</h4>
    @forelse ($upload->files as $file)
        <div id="file-wrapper">
          <img src="{{asset('assets/img/document-icon.png')}}" alt="Photo" width="250px" height="250px" />
          <form action="{{route('upload_file_download' , [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
            'file_id' => $file->id,
          ])}}" method="POST">
            @csrf
            <input type="submit" value="Download">
          </form>
        </div>
    @empty
      <p>No hay archivos</p>
    @endforelse

    {{-- Links --}}
    <h4>Links</h4>
    @forelse ($upload->links as $link)
      <div id="link-wrapper">
        <p>{{$link->link}}</p>
      </div>
    @empty
      <p>No hay links</p>
    @endforelse
  @empty
    <p>No hay uploads</p>
  @endforelse

  <div style="width: 100%; height: 3px; background: black"></div>
@endsection