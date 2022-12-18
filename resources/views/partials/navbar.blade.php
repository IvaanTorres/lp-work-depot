<div>
  <ul>
    @auth
      <li><a href="{{ route('courses_list_page') }}">Courses</a></li>
      {{-- <li><a href="{{ route('projects.create') }}">Create Project</a></li> --}}
      <form action="{{route('logout')}}" method="POST">
        @csrf
        <li><button type="submit">Logout</button></li>
      </form>
    @else
      <li><a href="{{ route('login_page') }}">Login</a></li>
      <li><a href="{{ route('register_page') }}">Register</a></li>
    @endauth
  </ul>
</div>