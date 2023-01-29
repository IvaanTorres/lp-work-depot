@extends('base')

@section('title', 'Edit Project')

@section('content')

  <h3 class="text-4xl font-semibold mb-20">Edit project</h3>

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

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="title">Title</label>
      <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title" value="{{$project->title}}">
    </div>

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="description">Description</label>
      <textarea class="rounded outline-none border border-gray-700 p-2" type="text" name="description" cols="30" rows="10">{{$project->description}}</textarea>
    </div>

    <div class="flex mt-5">
      <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Edit</button>
    </div>
  </form>
@endsection