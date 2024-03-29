<div class="h-full w-full text-center bg-gray-800 text-gray-100 py-10 flex flex-col items-center gap-10 font-semibold">
    <div class="h-full w-full flex flex-col gap-3">
      <a href="{{ route('courses_list_page') }}" class="flex justify-center">
        <img src="{{asset('assets/img/logo-moodle.png')}}" alt="logo-moodle" class="w-3/5 mb-5">
      </a>
      
      @auth
        <a href="{{ route('courses_list_page') }}">Courses</a>
      
        {{-- Just teacher --}}
        @if(auth()->user()->hasRole(App\Enums\Roles::Teacher->value))
          @if(isRouteActive('courses_list_page'))
            <a href="{{ route('course_creation_page') }}">New course</a>
          @elseif(isRouteActive('course_details_page'))
            <a href="{{ route('lesson_creation_page', ['course_id' => $course->id]) }}">New lesson</a>
          @endif
        @endif
      
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <button type="submit">Logout</button>
        </form>
      
      @else
        <a href="{{ route('register_page') }}">Register</a>
        <a href="{{ route('login_page') }}">Login</a>
      @endauth
    </div>

    @auth
      @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
        <p>Teacher</p>
      @elseif (Auth::user()->hasRole(App\Enums\Roles::Student->value))
        <p>Student</p>
      @endif
    @endauth
  </ul>
</div>