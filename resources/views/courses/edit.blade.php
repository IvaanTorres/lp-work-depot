@extends('base')

@section('content')
<form action="{{ route('course_modification', ['course_id' => $course->id]) }}" method="POST">
  @method('PUT')
  @csrf
  <div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ $course->title }}">
  </div>
  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ $course->description }}</textarea>
  </div>
  <div style="background: lightblue">
    <div id="lesson-create-button">Add lesson</div>
    <div id="lesson-field">
      @foreach ($course->lessons as $lesson)
        <div class="lesson-container">
          <div>
            <div class="lesson-delete-button">Delete lesson</div>
          </div>
          <div>
            <label for="lesson-title[]">Lesson Title</label>
            <input type="text" name="lesson-title[]" value="{{ $lesson->title }}">
          </div>
          <div>
            <label for="lesson-description[]">Lesson Description</label>
            <textarea name="lesson-description[]" cols="30" rows="10">{{ $lesson->description }}</textarea>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div>
    <button type="submit">Create</button>
  </div>
</form>

<script>
  const lessonCreateButton = document.getElementById('lesson-create-button');
  const lessonFieldsContainer = document.getElementById('lesson-field');
  const lessonContainers = document.getElementsByClassName('lesson-container');

  // Add event listener to the existing PHP lessons delete buttons
  for (let lessonContainer of lessonContainers) {
    const button = lessonContainer.getElementsByClassName('lesson-delete-button')[0];
    button.addEventListener('click', () => {
      lessonContainer.remove();
    });
  } 

  // Create first new lesson input
  createNewLesson();

  function createNewLesson(){
    // Create lesson template
    const lessonContainer = document.createElement('div');
    lessonContainer.classList.add('lesson-container');
    // [] is used to make Laravel understand that this is an array
    const lessonTemplate = `
      <div>
        <div class="lesson-delete-button">Delete lesson</div>
      </div>
      <div>
        <label for="lesson-title[]">Lesson Title</label>
        <input type="text" name="lesson-title[]">
      </div>
      <div>
        <label for="lesson-description[]">Lesson Description</label>
        <textarea name="lesson-description[]" cols="30" rows="10"></textarea>
      </div>
    `;
    lessonContainer.innerHTML = lessonTemplate;

    // Add event listener to delete button
    const lessonDeleteButton = lessonContainer.getElementsByClassName('lesson-delete-button')[0];
    lessonDeleteButton.addEventListener('click', () => {
      lessonContainer.remove();
    });

    // Add lesson to the lesson container
    lessonFieldsContainer.appendChild(lessonContainer);
  }

  // Add event listener to create lesson button
  lessonCreateButton.addEventListener('click', createNewLesson);
</script>
@endsection