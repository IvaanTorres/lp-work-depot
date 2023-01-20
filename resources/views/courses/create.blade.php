@extends('base')

@section('title', 'Create Course')

@section('content')
<form action="{{ route('course_creation') }}" method="POST">
  @csrf

  {{-- Errors --}}
  @if ($errors->any())
    @if ($errors->has('lesson-description.*'))
      <div>The lesson description must be a text and is mandatory if the title is set</div>
    @else
      <div>{{ $errors->first() }}</div>
    @endif
  @endif

  <div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}">
  </div>

  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
  </div>
  
  <div style="background: lightblue">
    <div id="lesson-create-button">Add lesson</div>
    <div id="lesson-create-field"></div>
  </div>
  <div>
    <button type="submit">Create</button>
  </div>
</form>

{{-- Create lessons --}}
<script>
  const lessonCreateButton = document.getElementById('lesson-create-button');
  const lessonFieldsContainer = document.getElementById('lesson-create-field');

  createNewLesson();

  function addLessonField() {
    createNewLesson();
  }

  function createNewLesson(){
    const lessonContainer = document.createElement('div');
    lessonContainer.classList.add('lesson-container');
    // [] is used to make Laravel understand that this is an array
    const lessonTemplate = `
      <div>
        <div class="lesson-delete-button">Delete lesson</div>
      </div>
      <div>
        <label for="lesson-title[]">Lesson Title</label>
        <input type="text" name="lesson-title[]" id="lesson-title">
      </div>
      <div>
        <label for="lesson-description[]">Lesson Description</label>
        <textarea name="lesson-description[]" id="lesson-description" cols="30" rows="10"></textarea>
      </div>
    `;
    lessonContainer.innerHTML = lessonTemplate;

    // Add event listener to delete button
    const lessonDeleteButton = lessonContainer.getElementsByClassName('lesson-delete-button')[0];
    lessonDeleteButton.addEventListener('click', () => {
      lessonContainer.remove();
    });

    lessonFieldsContainer.appendChild(lessonContainer);
  }

  lessonCreateButton.addEventListener('click', addLessonField);
</script>
@endsection