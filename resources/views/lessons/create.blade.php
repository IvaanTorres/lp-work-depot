@extends('base')

@section('content')
  {{-- Create form --}}
  <form action="{{ route('lesson_creation', [
    'course_id' => $course_id
  ]) }}" method="POST">
    @csrf

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
      <input type="text" name="title" id="title">
    </div>

    <div>
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10"></textarea>
    </div>

    <div style="background: lightblue">
      <div id="project-create-button">Add project</div>
      <div id="project-create-field"></div>
    </div>
    
    <div>
      <button type="submit">Create</button>
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
      <div>
        <div class="project-delete-button">Delete project</div>
      </div>
      <div>
        <label for="project-title[]">project Title</label>
        <input type="text" name="project-title[]" id="project-title">
      </div>
      <div>
        <label for="project-description[]">project Description</label>
        <textarea name="project-description[]" id="project-description" cols="30" rows="10"></textarea>
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