@extends('base')

@section('content')
  <h1>Welcome {{Session::get('username')}}</h1> {{-- Check --}}
  <form action="{{route('logout')}}" method="post">
    @csrf
    <button type="submit">Logout</button>
  </form>

  @if (Auth::user()->hasRole('teacher'))
    <a href="{{ route('course_list_page') }}">Dashboard Teacher</a>
  @elseif (Auth::user()->hasRole('student'))
    <a href="{{ route('course_list_page') }}">Dashboard Student</a>
  @endif

  {{-- Courses --}}
  <h2>Courses</h2>
  <ul>
    @foreach ($courses as $course)
      <li>
        <p>{{$course->title}}</p>
      </li>
    @endforeach
  </ul>
@endsection