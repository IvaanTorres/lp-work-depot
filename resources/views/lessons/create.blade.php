@extends('base')

@section('title', 'Create Lesson')

@section('content')

  <h3 class="text-4xl font-semibold mb-20">Create a new lesson</h3>

  {{-- Create form --}}
  <form action="{{ route('lesson_creation', [
    'course_id' => $course_id
  ]) }}" method="POST">
    @csrf

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="title">Title (*)</label>
      <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title" id="title">
      @error('title')
        <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="description">Description (*)</label>
      <textarea class="rounded outline-none border border-gray-700 p-2" name="description" id="description" cols="30" rows="10"></textarea>
      @error('description')
        <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
      @enderror
    </div>

    <h4 class="mt-10 mb-2 text-2xl font-semibold">Projects (Optional)</h4>
    <hr class="border-b-2 mb-1">

    <div class="bg-gray-100 border border-gray-300 p-5">
      <div id="project-create-field" class="grid grid-cols-3 gap-5 mb-5"></div>
      <div class="flex justify-between gap-3 items-end">
        <div class="transition ease-in-out duration-200 inline-block bg-gray-300 border border-gray-700 text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-400" id="project-create-button">Add</div>
        @error('project-title.*')
          <div class="text-red-500 font-semibold mt-2">The projects descriptions are mandatory if the description is set</div>
        @enderror
      </div>
    </div>
    
    <div class="flex mt-5">
      <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Create</button>
    </div>
  </form>

  {{-- Create lessons --}}
<script>
  const projectCreateButton = document.getElementById('project-create-button');
  const projectFieldsContainer = document.getElementById('project-create-field');

  createNewProject();

  function addProjectField() {
    createNewProject();
  }

  function createNewProject(){
    const projectContainer = document.createElement('div');
    projectContainer.classList.add('project-container');
    // [] is used to make Laravel understand that this is an array
    const projectTemplate = `
      <div class="bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
        <div class="flex flex-col gap-1 mb-5 max-w-lg">
          <label for="project-title[]">Title (*)</label>
          <input class="rounded outline-none p-2" type="text" name="project-title[]" id="project-title">
        </div>
        <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
          <label for="project-description[]">Description</label>
          <textarea class="rounded outline-none p-2" name="project-description[]" id="project-description" cols="30" rows="10"></textarea>
        </div>
        <div class="flex">
          <div class="project-delete-button ml-auto inline-block bg-red-300 border border-red-800 text-red-800 p-2 px-5 rounded-md cursor-pointer hover:bg-red-400 transition ease-in-out duration-200">Delete</div>
        </div>
      </div>
    `;
    projectContainer.innerHTML = projectTemplate;

    // Add event listener to delete button
    const projectDeleteButton = projectContainer.getElementsByClassName('project-delete-button')[0];
    projectDeleteButton.addEventListener('click', () => {
      projectContainer.remove();
    });

    projectFieldsContainer.appendChild(projectContainer);
  }

  projectCreateButton.addEventListener('click', addProjectField);
</script>
@endsection