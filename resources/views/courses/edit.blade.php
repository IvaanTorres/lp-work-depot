@extends('base')

@section('title', 'Edit Course')

@section('content')

<h3 class="text-4xl font-semibold mb-20">Edit Course</h3>
<form action="{{ route('course_modification', ['course_id' => $course->id]) }}" method="POST">
  @method('PUT')
  @csrf

  <div class="flex flex-col max-w-lg gap-1 mb-5">
    <label for="title">Title (*)</label>
    <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title" id="title" value="{{ $course->title }}">
    @error('title')
      <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
    @enderror
  </div>

  <div class="flex flex-col max-w-lg gap-1 mb-5">
    <label for="description">Description (*)</label>
    <textarea class="rounded outline-none border border-gray-700 p-2" name="description" id="description" cols="30" rows="10">{{ $course->description }}</textarea>
    @error('description')
      <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
    @enderror
  </div>

  <h4 class="mt-10 mb-2 text-2xl font-semibold">Lessons</h4>
  <hr class="border-b-2 mb-1">

  <div class="bg-gray-100 border border-gray-300 p-5">
    <div id="lesson-field" class="grid grid-cols-3 gap-5 mb-5">
      @foreach ($course->lessons as $lesson)
        <div class="lesson-container bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
          <div class="flex flex-col gap-1 mb-5 max-w-lg">
            <label for="lesson-title[]">Title (*)</label>
            <input class="rounded outline-none p-2" type="text" name="lesson-title[]" value="{{ $lesson->title }}">
          </div>
          <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
            <label for="lesson-description[]">Description</label>
            <textarea class="rounded outline-none p-2" name="lesson-description[]" cols="30" rows="10">{{ $lesson->description }}</textarea>
          </div>
          <div class="flex">
            <div class="lesson-delete-button ml-auto inline-block bg-red-300 border border-red-800 text-red-800 p-2 px-5 rounded-md cursor-pointer hover:bg-red-400 transition ease-in-out duration-200">Delete</div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="flex justify-between items-end gap-3">
      <div class="transition ease-in-out duration-200 inline-block bg-gray-300 border border-gray-700 text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-400" id="lesson-create-button">Add</div>
      @error('lesson-title.*')
        <p class="text-red-500 font-semibold mt-2">The lesson title is mandatory if the description is set</p>
      @enderror
    </div>
  </div>
  
  <div class="flex items-end gap-3 mt-5">
    <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Edit</button>
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
      <div class="bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
        <div class="flex flex-col gap-1 mb-5 max-w-lg">
          <label for="lesson-title[]">Title (*)</label>
          <input class="rounded outline-none p-2" type="text" name="lesson-title[]">
        </div>
        <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
          <label for="lesson-description[]">Description</label>
          <textarea class="rounded outline-none p-2" name="lesson-description[]" cols="30" rows="10"></textarea>
        </div>
        <div class="flex">
          <div class="lesson-delete-button ml-auto inline-block bg-red-300 border border-red-800 text-red-800 p-2 px-5 rounded-md cursor-pointer hover:bg-red-400 transition ease-in-out duration-200">Delete</div>
        </div>
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