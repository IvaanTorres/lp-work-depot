@extends('base')

@section('content')
  <h1>Students for this project</h1>
  <div>
    <form action="{{route('project_users_page', [
      'course_id' => $course_id,
      'lesson_id' => $lesson_id,
      'project_id' => $project_id
    ])}}" method="GET">
      <input id="search-field" type="text" name="search" value="{{request()->search}}">

      {{-- Errors --}}
      @if ($errors->any())
        <div>{{ $errors->first() }}</div>
      @endif
      <button id="search-button" type="submit" disabled>Search</button>
    </form>

    @if(request()->search)
      <a href="{{route('project_users_page', [
        'course_id' => $course_id,
        'lesson_id' => $lesson_id,
        'project_id' => $project_id,
        'order_by' => request()->order_by,
        'order' => request()->order,
      ])}}">Clear</a>
    @endif
  </div>

  {{-- Order by mark --}}
  <div>
    <a href="{{route('project_users_page', [
      'course_id' => $course_id,
      'lesson_id' => $lesson_id,
      'project_id' => $project_id,
      'search' => request()->search,
      'order_by' => 'mark',
      'order' => 'asc'
    ])}}">Order by mark asc</a>

    <a href="{{route('project_users_page', [
      'course_id' => $course_id,
      'lesson_id' => $lesson_id,
      'project_id' => $project_id,
      'search' => request()->search,
      'order_by' => 'mark',
      'order' => 'desc'
    ])}}">Order by mark desc</a>

    @if (request()->order_by === 'mark' && (request()->order === 'asc' || request()->order === 'desc'))
      <a href="{{route('project_users_page', [
        'course_id' => $course_id,
        'lesson_id' => $lesson_id,
        'project_id' => $project_id,
        'search' => request()->search,
      ])}}">Clear order by mark</a>
    @endif
  </div>

  <ul>
    @forelse ($students as $student)
      <li>
        <p>{{$student->name}}</p>

        <a href="{{route('project_user_details_page', [
          'course_id' => $course_id,
          'lesson_id' => $lesson_id,
          'project_id' => $project_id,
          'user_id' => $student->id,
        ])}}">See uploads</a>

        {{-- When student has already a mark --}}
        <div>
          <form action="{{route('project_evaluate', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project_id,
            'user_id' => $student->id,
          ])}}" method="POST">
            @csrf
            @method('PUT')

            <input type="number" name="mark" step="0.00001" value="{{$student->marks->firstWhere('project_id', $project_id)->mark ?? ''}}">

            {{-- Errors --}}
            @if ($errors->any())
              <div>{{ $errors->first() }}</div>
            @endif

            <button type="submit">Update mark</button>
          </form>
        </div>
      </li>
    @empty
      <li>No students</li>
    @endforelse
  </ul>

  <script>
    const searchField = document.getElementById('search-field');
    const searchButton = document.getElementById('search-button');

    searchField.addEventListener('input', () => {
      // Min 3 chars to use the search bar
      if (searchField.value.length > 3) {
        searchButton.disabled = false;
      } else {
        searchButton.disabled = true;
      }
    });
  </script>

@endsection