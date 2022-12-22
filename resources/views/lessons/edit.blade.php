@extends('base')

@section('content')
  {{-- Edit form --}}
  <form action="{{ route('lesson_modification', [
    'course_id' => $course->id,
    'lesson_id' => $lesson->id
  ]) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
      <label for="title">Title</label>
      <input type="text" name="title" id="title" value="{{ $lesson->title }}">
    </div>
    <div>
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10">{{ $lesson->description }}</textarea>
    </div>
  </div>
    <div>
      <button type="submit">Edit</button>
    </div>
  </form>
@endsection