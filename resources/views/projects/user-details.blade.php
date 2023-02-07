@extends('base')
{{--  --}}
@section('title', 'Upload Details Of The Student')

@section('content')

  <style>
    .download-icon {
        display: none;
    }

    .file-actions-wrapper {
        width: 100%;
        z-index: 999;
    }

    .file-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: none;
    }

    .file {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .file-item:hover>div>.download-icon {
        display: block;
    }

    .file-item:hover>.file-title {
        display: block;
    }

    .file-item:hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }
  </style>

  @if (session('user_update_mark_info'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline">{{session('user_update_mark_info')}}</span>
    </div>
  @endif

  <div class="mb-10">
    <h3 class="text-4xl font-semibold">{{ $project->title }}</h3>
    <p class="mt-3">{{ $project->description }}</p>
    
    <div class="mt-20">
      <h3 class="text-2xl font-semibold">Student Info</h3>
      <hr class="border-b-2 mb-5">
      
      <div class="flex flex-col gap-3">
        <div>
          <p class="font-semibold text-sm">User</p>
          <p class="font-semibold">{{ucfirst($user->name)}}</p>
        </div>
        <div>
          <p class="font-semibold text-sm">Email</p>
          <a class="text-orange-500 font-semibold" href="mailto:{{$user->email}}">{{$user->email}}</a>
        </div>
        <div>
          <p class="font-semibold text-sm">Mark (MAX: 20)</p>
          <form action="{{route('project_evaluate', [
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'project_id' => $project->id,
            'user_id' => $user->id,
          ])}}" method="POST">
            @csrf
            @method('PUT')
            <input class="rounded outline-none border border-gray-700 p-2 mt-2 mr-2" type="number" name="mark" value="{{$user->marks->firstWhere('project_id', $project->id)->mark ?? ''}}">
            <button class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 font-semibold text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400" type="submit">Update</button>
            @error('mark')
              <p class="text-red-500 font-semibold mt-2">{{$message}}</p>
            @enderror
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div>
    <h3 class="text-2xl font-semibold">Upload Details</h3>
    <hr class="border-b-2 mb-5">

    <div class="grid grid-cols-2 gap-10">
      <div>
          <h4 class="mb-2 text-md font-semibold">Info</h4>
          <hr class="border-b-2 mb-5">
      
          <div class="flex flex-col gap-1 mb-5">
              <p class="font-semibold text-md">Title</p>
              <p>{{ $upload->title ?? 'There\'s no title set' }}</p>
          </div>
      
          <div class="flex flex-col gap-1 mb-5">
            <p class="font-semibold text-md">Description</p>
            <p>{{ $upload->description ?? 'There\'s no description set' }}</p>
          </div>
      </div>
      
      {{-- Files --}}
      <div>
        <h4 class="mb-2 text-md font-semibold">Uploaded Content</h4>
        <hr class="border-b-2 mb-5">

        <div class="bg-gray-100 p-3 border border-gray-800">
          @if ($upload != null)
            <div class="mb-5">
              <h4 class="font-semibold text-md">Files</h4>
              <div class="grid grid-cols-4 gap-3 mt-3">
                @forelse ($upload->files as $file)
                    <div id="file-wrapper" class="file-item transition ease-in-out duration-200 relative overflow-hidden">
                      <p class="file-title w-full text-sm text-white font-semibold hidden absolute top-3 left-0 px-2 z-50">
                        {{ $file->title ?? null }}
                      </p>
                      <img class="file w-28 h-28" src="{{ asset('assets/img/uploaded-file.png') }}" alt="Photo" />
                      <div class="file-actions-wrapper absolute bottom-0 right-0 flex">
                        <form class="download-icon w-full" action="{{route('upload_file_download' , [
                          'course_id' => $course_id,
                          'lesson_id' => $lesson_id,
                          'project_id' => $project->id,
                          'file_id' => $file->id,
                        ])}}" method="POST">
                          @csrf
                          <button class="p-2 w-full bg-gray-500 text-white cursor-pointer hover:bg-gray-600" type="submit">
                            <i class="fa-solid fa-download"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                @empty
                  <p>There's no files</p>
                @endforelse
              </div>
            </div>
          
            {{-- Links --}}
            <div>
              <h4 class="font-semibold text-md mb-2">Links</h4>
              <div class="flex flex-col gap-3">
                @forelse ($upload->links as $link)
                  <div id="link-wrapper" class="bg-orange-100 border border-orange-600 p-3 flex justify-between rounded-md">
                    <a class="font-semibold underline" href="{{ $link->link }}"
                      target="_blank">{{ $link->link }}</a>
                  </div>
                @empty
                  <p>There's no links</p>
                @endforelse
              </div>
            </div>
          @else
            <p>There's no upload content</p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection