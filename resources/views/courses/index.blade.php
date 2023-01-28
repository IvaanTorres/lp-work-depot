@extends('base')

@section('title', 'Courses')

@section('content')
  <div>
    <h3 class="text-4xl font-semibold">Welcome <span class="text-orange-500">{{ucfirst(Auth::user()->name)}}</span> to your personal space ! ✨</h3>
  </div>

  {{-- Courses --}}
  <div>
    <h2 class="text-3xl font-semibold mt-20">Courses</h2>
    <hr class="mt-3 border-t-2">
    <div class="mt-5 grid grid-cols-4 gap-5">
      @forelse ($courses as $course)
        <a href="{{ route('course_details_page', ['course_id' => $course->id]) }}">
          <div class="rounded-xl border border-orange-700 min-h-[250px] p-5 bg-orange-100 hover:bg-orange-200 transition-all ease-in-out duration-300">
            <div>
              <h3 class="text-xl font-semibold">{{ $course->title }}</h3>
              <p class="mt-3 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $course->description }}</p>
            </div>
          </div>
        </a>
      @empty
        <div class="mt-4">
          <p>You are not linked to any course yet.</p>
        </div>
      @endforelse
    </div>
  </div>
@endsection