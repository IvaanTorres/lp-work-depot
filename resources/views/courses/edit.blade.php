@extends('base')

@section('content')
<form action="{{ route('course_modification', ['course_id' => $course->id]) }}" method="POST">
  @method('PUT')
  @csrf
  <div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ $course->title }}">
  </div>
  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ $course->description }}</textarea>
  </div>
  <div>
    <button type="submit">Create</button>
  </div>
</form>
@endsection