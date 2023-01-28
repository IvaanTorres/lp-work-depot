@extends('base')

@section('title', 'Edit Lesson')

@section('content')

  <h3 class="text-4xl font-semibold mb-20">Edit Lesson</h3>

  {{-- Edit form --}}
  <form action="{{ route('lesson_modification', [
    'course_id' => $course->id,
    'lesson_id' => $lesson->id
  ]) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Errors --}}
    @if ($errors->any())
      @if ($errors->has('project-description.*'))
        <div>The project description must be a text and is mandatory if the title is set</div>
      @else
        <div>{{ $errors->first() }}</div>
      @endif
    @endif

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="title">Title</label>
      <input class="rounded outline-none border border-gray-700 p-2" type="text" name="title" id="title" value="{{ $lesson->title }}">
    </div>

    <div class="flex flex-col max-w-lg gap-1 mb-5">
      <label for="description">Description</label>
      <textarea class="rounded outline-none border border-gray-700 p-2" name="description" id="description" cols="30" rows="10">{{ $lesson->description }}</textarea>
    </div>

    <h4 class="mt-10 mb-2 text-2xl font-semibold">Projects</h4>
    <hr class="border-b-2 mb-1">

    <div class="bg-gray-100 border border-gray-300 p-5">
      <div id="project-field" class="grid grid-cols-3 gap-5 mb-5">
        @foreach ($lesson->projects as $project)
          <div class="project-container bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
            <div class="flex flex-col gap-1 mb-5 max-w-lg">
              <label for="project-title[]">Title</label>
              <input class="rounded outline-none p-2" type="text" name="project-title[]" value="{{ $project->title }}">
            </div>
            <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
              <label for="project-description[]">Description</label>
              <textarea class="rounded outline-none p-2" name="project-description[]" cols="30" rows="10">{{ $project->description }}</textarea>
            </div>
            <div class="flex mt-5">
              <div class="project-delete-button ml-auto inline-block bg-red-300 border border-red-800 text-red-800 p-2 px-5 rounded-md cursor-pointer hover:bg-red-400 transition ease-in-out duration-200">Delete</div>
            </div>
          </div>
        @endforeach
      </div>
      <div id="project-create-button" class="transition ease-in-out duration-200 inline-block bg-gray-300 border border-gray-700 text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-400">Add</div>
    </div>
    
    <div class="flex mt-5">
      <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Edit</button>
    </div>
  </form>

  <script>
    const projectCreateButton = document.getElementById('project-create-button');
    const projectFieldsContainer = document.getElementById('project-field');
    const projectContainers = document.getElementsByClassName('project-container');
  
    // Add event listener to the existing PHP projects delete buttons
    for (let projectContainer of projectContainers) {
      const button = projectContainer.getElementsByClassName('project-delete-button')[0];
      button.addEventListener('click', () => {
        projectContainer.remove();
      });
    } 
  
    // Create first new project input
    createNewProject();
  
    function createNewProject(){
      // Create project template
      const projectContainer = document.createElement('div');
      projectContainer.classList.add('project-container');
      // [] is used to make Laravel understand that this is an array
      const projectTemplate = `
        <div class="bg-gray-300 border border-gray-400 min-h-[300px] p-5 flex flex-col rounded-md">
          <div class="flex flex-col gap-1 mb-5 max-w-lg">
            <label for="project-title[]">Project Title</label>
            <input class="rounded outline-none p-2" type="text" name="project-title[]">
          </div>
          <div class="flex flex-col gap-1 mb-5 max-w-lg h-[200px]">
            <label for="project-description[]">Project Description</label>
            <textarea class="rounded outline-none p-2" name="project-description[]" cols="30" rows="10"></textarea>
          </div>
          <div class="flex mt-5">
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
  
      // Add project to the project container
      projectFieldsContainer.appendChild(projectContainer);
    }
  
    // Add event listener to create lesson button
    projectCreateButton.addEventListener('click', createNewProject);
  </script>
@endsection