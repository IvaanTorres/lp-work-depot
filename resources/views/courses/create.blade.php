@extends('base')

@section('title', 'Create Course')

@section('content')

<h3 class="text-4xl font-semibold">Create a new course</h3>
<form class="mt-20" action="{{ route('course_creation') }}" method="POST">
  @csrf

  {{-- Errors --}}
  @if ($errors->any())
    @if ($errors->has('lesson-description.*'))
      <div>The lesson description must be a text and is mandatory if the title is set</div>
    @else
      <div>{{ $errors->first() }}</div>
    @endif
  @endif

  <div class="flex flex-col max-w-lg gap-1 mb-5">
    <label for="title">Title</label>
    <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title" id="title" value="{{ old('title') }}">
  </div>

  <div class="flex flex-col max-w-lg gap-1 mb-5">
    <label for="description">Description</label>
    <textarea class="rounded outline-none border border-gray-700 p-2" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
  </div>
  
  <h4 class="mt-10 mb-2 text-2xl font-semibold">Lessons (Optional)</h4>
  <hr class="border-b-2 mb-1">
  
  <div class="bg-gray-100 border border-gray-300 p-5">
    <div id="lesson-create-field" class="grid grid-cols-3 gap-5 mb-5"></div>
    <div id="lesson-create-button" class="transition ease-in-out duration-200 inline-block bg-gray-300 border border-gray-700 text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-400">Add lesson</div>
  </div>

  <div class="flex mt-5">
    <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Create</button>
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
      <div class="bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
        <div class="flex flex-col gap-1 mb-5 max-w-lg">
          <label for="lesson-title[]">Title</label>
          <input class="rounded outline-none p-2" type="text" name="lesson-title[]" id="lesson-title">
        </div>
        <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
          <label for="lesson-description[]">Description</label>
          <textarea class="rounded outline-none p-2" name="lesson-description[]" id="lesson-description" cols="30" rows="10"></textarea>
        </div>
        <div class="flex">
          <div class="lesson-delete-button ml-auto inline-block bg-red-300 border border-red-800 text-red-800 p-2 px-5 rounded-md cursor-pointer hover:bg-red-400 transition ease-in-out duration-200">Delete lesson</div>
        </div>
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