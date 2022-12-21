@extends('base')

@section('content')
<form action="{{ route('course_creation') }}" method="POST">
  @csrf
  <div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}">
  </div>
  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
  </div>
  <div>
    <button type="submit">Create</button>
  </div>
</form>
@endsection