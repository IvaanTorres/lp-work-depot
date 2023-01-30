@extends('base')

@section('title', 'Course Details')

@section('content')
  @if (session('course_create_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('course_create_info')}}</span>
    </div>
  @endif

  @if (session('course_update_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('course_update_info')}}</span>
    </div>
  @endif

  @if (session('lesson_create_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('lesson_create_info')}}</span>
    </div>
  @endif

  @if (session('lesson_update_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('lesson_update_info')}}</span>
    </div>
  @endif
  
  @if (session('lesson_delete_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('lesson_delete_info')}}</span>
    </div>
  @endif
  
  @if (session('project_create_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('project_create_info')}}</span>
    </div>
  @endif
  
  @if (session('project_update_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('project_update_info')}}</span>
    </div>
  @endif
  
  @if (session('project_delete_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('project_delete_info')}}</span>
    </div>
  @endif

  <div class="mb-16">
    <h3 class="text-4xl font-semibold">{{$course->title}}</h3>
    <p class="mt-5">{{$course->description}}</p>
    
    {{-- Just teacher --}}
    @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
      <form class="flex gap-3 my-6" action="{{route('course_deletion', ['course_id' => $course->id])}}" method="POST">
        @csrf
        @method('DELETE')

        <a class="font-medium rounded-full min-w-[100px] text-center bg-gray-200 border hover:bg-gray-300 text-gray-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2" href="{{route('course_users_page', [
          'course_id' => $course->id,
        ])}}">Add Students</a>
        <a class="font-medium rounded-full min-w-[100px] text-center bg-blue-200 border hover:bg-blue-300 text-blue-800 transition-all ease-in-out duration-200 border-blue-600 px-3 py-2" href="{{route('course_modification_page', ['course_id' => $course->id])}}">Edit</a>
        <input type="hidden" name="course_id" value="{{$course->id}}">
        <button class="font-medium rounded-full min-w-[100px] text-center bg-red-200 border hover:bg-red-300 text-red-800 transition-all ease-in-out duration-200 border-red-600 px-3 py-2" type="submit">Delete</button>
      </form> 
      @endif
  </div>
  
  {{-- Lessons --}}
  <div>
    <h4 class="text-3xl font-semibold">Lessons</h4>
    <hr class="my-3 border-t-2">
    <div class="grid grid-cols-1 gap-10">
      @forelse ($course->lessons as $lesson)
        <div>
          <div>
            <p class="text-xl mb-1">{{ $lesson->title }}</p>
            <p class="text-gray-600 mb-1">{{ $lesson->description }}</p>
    
            {{-- Just teacher --}}
            @if(Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
              <form class="flex gap-3" action="{{route('lesson_deletion', [
                'course_id' => $course->id,
                'lesson_id' => $lesson->id
              ])}}" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                <a class="text-blue-800 hover:text-blue-900 font-medium underline" href="{{ route('lesson_modification_page', [
                  'course_id' => $course->id,
                  'lesson_id' => $lesson->id
                ]) }}">Edit</a>
                <a class="text-gray-700 hover:text-gray-900 font-medium underline" href="{{ route('project_creation_page', [
                  'course_id' => $course->id,
                  'lesson_id' => $lesson->id
                ]) }}">Create New Project</a>
                <button class="text-red-700 hover:text-red-900 font-medium underline" type="submit">Delete</button>
              </form>
            @endif
          </div>
          @if ($lesson->projects && $lesson->projects->count() > 0)
            <div>
              <p class="text-lg mb-1 mt-2">Projects:</p>
              <div class="grid grid-cols-1 gap-3">
                @foreach ($lesson->projects as $project)
                  <div class="flex justify-between bg-orange-100 p-3 rounded-md border border-orange-600">
                    <a class="font-semibold" href="{{ route('project_details_page', [
                      'course_id' => $course->id,
                      'lesson_id' => $lesson->id,
                      'project_id' => $project->id
                    ]) }}">
                      {{ $project->title }}
                    </a>
                    
                    {{-- Just teacher --}}
                    @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
                      <form class="flex gap-5" action="{{ route('project_deletion', [
                        'course_id' => $course->id,
                        'lesson_id' => $lesson->id,
                        'project_id' => $project->id
                        ]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <a class="font-semibold text-orange-600" href="{{ route('project_modification_page', [
                          'course_id' => $course->id,
                          'lesson_id' => $lesson->id,
                          'project_id' => $project->id
                        ]) }}">Edit</a>
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <button class="font-semibold text-orange-600" type="submit">Delete</button>
                      </form>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      @empty
        <p>There's no lessons yet</p>
      @endforelse
    </div>
  </div>

@endsection