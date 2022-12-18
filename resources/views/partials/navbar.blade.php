<div>
  <ul>
    @auth
      <li><a href="{{ route('courses_list_page') }}">Courses</a></li>
      {{-- <li><a href="{{ route('projects.create') }}">Create Project</a></li> --}}
      <form action="{{route('logout')}}" method="POST">
        @csrf
        <li><button type="submit">Logout</button></li>
      </form>

      {{-- Teacher create actions --}}
      @if(auth()->user()->hasRole(App\Enums\Roles::Teacher->value))
        @if(isRouteActive('courses_list_page'))
          <li><a href="{{ route('courses_list_page') }}">Create new course</a></li>
        @elseif(isRouteActive('course_details_page'))
          <li><a href="{{ route('courses_list_page') }}">Create new lesson</a></li>
          <li><a href="{{ route('courses_list_page') }}">Create new project</a></li>
        @endif
      @endif
    @else
      <li><a href="{{ route('login_page') }}">Login</a></li>
      <li><a href="{{ route('register_page') }}">Register</a></li>
    @endauth
  </ul>
</div>