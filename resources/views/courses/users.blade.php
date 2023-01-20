@extends('base')

@section('title', 'Linked Students')

@section('content')
  <h1>Students linked to this course</h1>

  <div>
    <form action="{{route('course_users_page', [
      'course_id' => $course_id,
    ])}}" method="GET">
      <input id="search-field" type="text" name="search" value="{{request()->search}}">

      {{-- Errors --}}
      @error('search')
        <div>{{ $message }}</div>
      @enderror

      <button id="search-button" type="submit" disabled>Search</button>
    </form>

    @if(request()->search)
      <a href="{{route('course_users_page', [
        'course_id' => $course_id,
      ])}}">Clear</a>
    @endif
  </div>

  <ul>
    @forelse ($students as $student)
      <li>
        <p>
          {{$student->name}} 
          <form action="{{route('course_unlink_users', [
            'course_id' => $course_id,
            'user_id' => $student->id
          ])}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{$student->id}}">
            <button type="submit">Unlink</button>
          </form>
        </p>
      </li>
    @empty
      <li>No results</li>
    @endforelse
  </ul>
  {{-- Add user --}}

  {{-- Errors --}}
  @if ($errors->any())
    <div>{{ $errors->first() }}</div>
  @endif

  <form action="{{route('course_link_users', ['course_id' => $course_id])}}" method="POST">
    @csrf
    <input type="hidden" name="course_id" value="{{$course_id}}">
    <input type="text" name="user_email" placeholder="User email">
    <button type="submit">Link user</button>
  </form>

  <script>
    const searchField = document.getElementById('search-field');
    const searchButton = document.getElementById('search-button');

    searchField.addEventListener('input', () => {
      // Min 3 chars to use the search bar
      if (searchField.value.length > 3) {
        searchButton.disabled = false;
      } else {
        searchButton.disabled = true;
      }
    });
  </script>
@endsection