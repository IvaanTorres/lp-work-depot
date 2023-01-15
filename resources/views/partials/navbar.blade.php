<div>
  <ul>
    @auth
      <li><a href="{{ route('courses_list_page') }}">Courses</a></li>

      {{-- Just teacher --}}
      @if(auth()->user()->hasRole(App\Enums\Roles::Teacher->value))
        @if(isRouteActive('courses_list_page'))
          <li><a href="{{ route('course_creation_page') }}">Create new course</a></li>
        @elseif(isRouteActive('course_details_page'))
          <li><a href="{{ route('lesson_creation_page', ['course_id' => $course->id]) }}">Create new lesson</a></li>
        @endif
      @endif

      <form action="{{route('logout')}}" method="POST">
        @csrf
        <li><button type="submit">Logout</button></li>
      </form>

    @else
      <li><a href="{{ route('register_page') }}">Register</a></li>
      <li><a href="{{ route('login_page') }}">Login</a></li>
    @endauth
  </ul>
</div>