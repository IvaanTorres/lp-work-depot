@extends('base')

@section('title', 'Project Details')

@section('content')
  <h3 class="text-4xl font-semibold">{{$project->title}}</h3>
  <p class="mt-5">{{$project->description}}</p>

  {{-- Just student --}}
  @if (Auth::user()->hasRole(App\Enums\Roles::Student->value))
    <p>Mark: {{Auth::user()->marks->firstWhere('project_id', $project->id)->mark ?? 'Not marked yet'}}</p>
  @endif

  {{-- Just teacher --}}
  @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
    <form class="flex gap-3 mt-6" action="{{route('project_deletion', [
      'course_id' => $course_id,
      'lesson_id' => $lesson_id,
      'project_id' => $project->id
    ])}}" method="POST">
      @csrf
      @method('DELETE')

      <input type="hidden" name="project_id" value="{{$project->id}}">
      <a class="font-medium rounded-full min-w-[100px] text-center bg-gray-200 border hover:bg-gray-300 text-gray-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2" href="{{route('project_users_page', [
        'course_id' => $course_id,
        'lesson_id' => $lesson_id,
        'project_id' => $project->id
      ])}}">See students</a>
      <a class="font-medium rounded-full min-w-[100px] text-center bg-blue-200 border hover:bg-blue-300 text-blue-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2" href="{{route('project_modification_page', [
        'course_id' => $course_id,
        'lesson_id' => $lesson_id,
        'project_id' => $project->id
      ])}}">Edit</a>
      <button class="font-medium rounded-full min-w-[100px] text-center bg-red-200 border hover:bg-red-300 text-red-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2" type="submit">Delete</button>
    </form>
  @endif

  {{-- Just student --}}
  @if (Auth::user()->hasRole(App\Enums\Roles::Student->value))
    <h2>Upload</h2>

    <p>Title: {{$upload->title}}</p>
    <p>Description: {{$upload->description}}</p>

    {{-- Uploaded files and links --}}
    {{-- Files --}}
    <h4>Files</h4>
    @foreach ($upload->files as $file)
        <div id="file-wrapper">
          <form action="{{route('upload_deletion', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
            'document_id' => $file->id,
          ])}}" method="post">
            @csrf
            @method('DELETE')
            <input type="hidden" name="file_id" value="{{$file->id}}">
            <input type="submit" value="Delete file">  
          </form>
          <img src="{{asset('assets/img/document-icon.png')}}" alt="Photo" width="250px" height="250px" />
          <form action="{{route('upload_file_download' , [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
            'file_id' => $file->id,
          ])}}" method="POST">
            @csrf
            <input type="submit" value="Download">
          </form>
        </div>
    @endforeach

    {{-- Links --}}
    <h4>Links</h4>
    @foreach ($upload->links as $link)
      <div id="link-wrapper">
        <p>{{$link->link}}</p>
        <form action="{{route('upload_deletion', [
          'course_id' => $course_id,
          'lesson_id' => $lesson_id,
          'project_id' => $project->id,
          'document_id' => $link->id,
        ])}}" method="post">
          @csrf
          @method('DELETE')
          <input type="hidden" name="link_id" value="{{$link->id}}">
          <input type="submit" value="Delete link">  
        </form>
      </div>
    @endforeach

    <div style="width: 100%; height: 3px; background: black"></div>

    {{-- Errors --}}

    @if ($errors->any())
      {{-- File or link error --}}
      @if ($errors->has('upload_link.*') || $errors->has('upload_file.*'))
        @if ($errors->has('upload_link.*'))
          <div class="alert alert-danger">The links must be valid URL's</div>
        @endif
        @if ($errors->has('upload_file.*'))
          <div class="alert alert-danger">Some file is too big</div>
        @endif
      @else
        <div>{{ $errors->first() }}</div>
      @endif
    @endif

    {{-- Upload form --}}
    <form action="{{route('upload_creation', [
      'course_id' => $course_id,
      'lesson_id' => $lesson_id,
      'project_id' => $project->id,
    ])}}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Title --}}
      <label for="upload_title">Title</label>
      <input type="text" name="upload_title" id="upload_title" value="{{$upload->title}}">

      {{-- Description --}}
      <label for="upload_description">Description</label>
      <input type="text" name="upload_description" id="upload_description" value="{{$upload->description}}">

      {{-- Files --}}
      <br>
      <div style="background: lightblue">
        <div id="file-create-button">Add file</div>
        <div id="file-create-field"></div>
      </div>
        
      {{-- Links --}}
      <br>
      <div style="background: lightblue">
        <div id="link-create-button">Add link</div>
        <div id="link-create-field"></div>
      </div>
      <br>
      <button type="submit">Upload</button>
    </form>

    {{-- Files --}}
    <script>
      const fileCreateButton = document.getElementById('file-create-button');
      const fileFieldsContainer = document.getElementById('file-create-field');
    
      createNewFile();
    
      function addFileField() {
        createNewFile();
      }
    
      function createNewFile(){
        const fileContainer = document.createElement('div');
        fileContainer.classList.add('file-container');
        // [] is used to make Laravel understand that this is an array
        const fileTemplate = `
          <div class="file-delete-button">Delete</div>
          <input type="file" name="upload_file[]" placeholder="Upload file">
        `;
        fileContainer.innerHTML = fileTemplate;
    
        // Add event listener to delete button
        const fileDeleteButton = fileContainer.getElementsByClassName('file-delete-button')[0];
        fileDeleteButton.addEventListener('click', () => {
          fileContainer.remove();
        });
    
        fileFieldsContainer.appendChild(fileContainer);
      }
    
      fileCreateButton.addEventListener('click', addFileField);
    </script>

    {{-- Links --}}
    <script>
      const linkCreateButton = document.getElementById('link-create-button');
      const linkFieldsContainer = document.getElementById('link-create-field');
    
      createNewLink();
    
      function addLinkField() {
        createNewLink();
      }
    
      function createNewLink(){
        const linkContainer = document.createElement('div');
        linkContainer.classList.add('link-container');
        // [] is used to make Laravel understand that this is an array
        const linkTemplate = `
          <div class="link-delete-button">Delete</div>
          <input type="link" name="upload_link[]" placeholder="Upload link">
        `;
        linkContainer.innerHTML = linkTemplate;
    
        // Add event listener to delete button
        const linkDeleteButton = linkContainer.getElementsByClassName('link-delete-button')[0];
        linkDeleteButton.addEventListener('click', () => {
          linkContainer.remove();
        });
    
        linkFieldsContainer.appendChild(linkContainer);
      }
    
      linkCreateButton.addEventListener('click', addLinkField);
    </script>
  @endif
  
@endsection