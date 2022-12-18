@extends('base')

@section('title', 'Create Course')

@section('head')
  <script src="{{ asset('js/courses/create.js') }}"></script>
@endsection

@section('content')
  <h1>Create Course</h1>

  {{-- Create course form --}}
  <form method="POST" action="{{ route('course_creation') }}">
    @csrf

    {{-- Title --}}
    <div>
      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
      @error('title')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- Description --}}
    <div>
      <label for="description">Description</label>
      <input id="description" type="text" name="description" value="{{ old('description') }}" required>
      @error('description')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- Lessons --}}
    <div id="course-lesson-wrapper">
      <label for="lessons">Lessons</label>
      <input id="lessons" type="text" name="lessons" value="{{ old('lessons') }}" required>
      @error('lessons')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- Submit --}}
    <div>
      <button type="submit">Create</button>
    </div>
  </form>
@endsection

