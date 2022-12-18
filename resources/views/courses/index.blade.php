@extends('base')

@section('content')
  <h1>Welcome {{Session::get('username')}}</h1> {{-- Check --}}
  <form action="{{route('logout')}}" method="post">
    @csrf
    <button type="submit">Logout</button>
  </form>

  @if (Auth::user()->hasRole('teacher'))
    <a href="{{ route('courses_list_page') }}">Dashboard Teacher</a>
  @elseif (Auth::user()->hasRole('student'))
    <a href="{{ route('courses_list_page') }}">Dashboard Student</a>
  @endif

  {{-- Courses --}}
  <h2>Courses</h2>
  <ul>
    @foreach ($courses as $course)
      <li>
        <a href="{{ route('course_details_page', ['course_id' => $course->id]) }}">
          {{ $course->title }}
        </a>
      </li>
    @endforeach
  </ul>
@endsection