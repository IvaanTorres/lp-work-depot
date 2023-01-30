@extends('base')

@section('title', 'Create Project')

@section('content')

  <h3 class="text-4xl font-semibold mb-20">Create a new project</h3>

  {{-- Cretae project form --}}
  <form action="{{route('project_creation', [
    'course_id' => $course_id,
    'lesson_id' => $lesson_id
  ])}}" method="POST">
    @csrf

    <input type="hidden" name="lesson_id" value="{{$lesson_id}}">

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="title">Title (*)</label>
      <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title">
      @error('title')
        <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="description">Description (*)</label>
      <textarea class="rounded outline-none border border-gray-700 p-2" cols="30" rows="10" name="description"></textarea>
      @error('description')
        <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex mt-5">
      <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Create</button>
    </div>
    
  </form>
@endsection