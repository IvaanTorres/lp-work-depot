@extends('base')

@section('content')
  <h1>Welcome {{Auth::user()->name}}</h1> {{-- Check --}}

  @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
    <p>Dashboard Teacher</p>
  @elseif (Auth::user()->hasRole(App\Enums\Roles::Student->value))
    <p>Dashboard Student</p>
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