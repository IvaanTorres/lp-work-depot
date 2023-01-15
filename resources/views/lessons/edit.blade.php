@extends('base')

@section('content')
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

    <div>
      <label for="title">Title</label>
      <input type="text" name="title" id="title" value="{{ $lesson->title }}">
    </div>

    <div>
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10">{{ $lesson->description }}</textarea>
    </div>

    <div style="background: lightblue">
      <div id="project-create-button">Add project</div>
      <div id="project-field">
        @foreach ($lesson->projects as $project)
          <div class="project-container">
            <div>
              <div class="project-delete-button">Delete project</div>
            </div>
            <div>
              <label for="project-title[]">Project Title</label>
              <input type="text" name="project-title[]" value="{{ $project->title }}">
            </div>
            <div>
              <label for="project-description[]">project Description</label>
              <textarea name="project-description[]" cols="30" rows="10">{{ $project->description }}</textarea>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    
    <div>
      <button type="submit">Edit</button>
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
        <div>
          <div class="project-delete-button">Delete project</div>
        </div>
        <div>
          <label for="project-title[]">Project Title</label>
          <input type="text" name="project-title[]">
        </div>
        <div>
          <label for="project-description[]">Project Description</label>
          <textarea name="project-description[]" cols="30" rows="10"></textarea>
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