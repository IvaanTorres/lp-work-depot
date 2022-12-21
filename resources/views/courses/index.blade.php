@extends('base')

@section('title', 'Dashboard')

@section('head')
  {{-- Add custom CSS and JS --}}
@endsection

@section('content')
  <div>
    <h1>Welcome</h1> {{-- Check --}}
    {{-- <button x-on:click="open = !open">Click</button>
    <span x-text="open"></span> --}}

    <x-card>

    <form action="{{route('logout')}}" method="post">
      @csrf
      <button type="submit">Logout</button>
    </form>
    
    @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
      <a href="{{ route('courses_list_page') }}">Dashboard Teacher</a>
    @elseif (Auth::user()->hasRole(App\Enums\Roles::Student->value))
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
  </div>
@endsection