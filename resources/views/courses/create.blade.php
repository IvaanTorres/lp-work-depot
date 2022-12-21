@extends('base')

@section('content')
<form action="{{ route('course_creation') }}" method="POST">
  @csrf
  <div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}">
  </div>
  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
  </div>
  <div>
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
    // [] is used to make Laravel understand that this is an array
    const lessonTemplate = `
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

    lessonFieldsContainer.appendChild(lessonContainer);
  }

  lessonCreateButton.addEventListener('click', addLessonField);
</script>
@endsection