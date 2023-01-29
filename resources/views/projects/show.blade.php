@extends('base')

@section('title', 'Project Details')

@section('content')
    <style>
        .delete-icon,
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

        .file-item:hover>div>.delete-icon {
            display: block;
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

        .mark-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .round {
            transform: rotate(-90deg);
            transition: all 1s ease-in-out;

            /* SVG */
            fill: none;
            stroke: #f97316;
            stroke-width: 15;
            stroke-linecap: round;
            stroke-dasharray: 0 999;
        }
    </style>

    <div class="mb-20">
        <h3 class="text-4xl font-semibold">{{ $project->title }}</h3>
        <p class="mt-3">{{ $project->description }}</p>

        {{-- Just student --}}
        @if (Auth::user()->hasRole(App\Enums\Roles::Student->value))
            @if (Auth::user()->marks->firstWhere('project_id', $project->id) !== null)
                <div class="relative inline-block mt-5">
                    <svg class="round" viewbox="0 0 100 100" width="80" height="80"
                        data-percent="{{ (Auth::user()->marks->firstWhere('project_id', $project->id)->mark * 100) / 20 }}">
                        <circle cx="50" cy="50" r="40" />
                    </svg>
                    <p class="mark-value text-orange-500 font-semibold">20/20</p>
                </div>
            @else
                <p class="text-red-500 font-semibold mt-5">Not graded yet</p>
            @endif
        @endif
    </div>

    {{-- Just teacher --}}
    @if (Auth::user()->hasRole(App\Enums\Roles::Teacher->value))
        <form class="flex gap-3 mt-6"
            action="{{ route('project_deletion', [
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'project_id' => $project->id,
            ]) }}"
            method="POST">
            @csrf
            @method('DELETE')

            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <a class="font-medium rounded-full min-w-[100px] text-center bg-gray-200 border hover:bg-gray-300 text-gray-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2"
                href="{{ route('project_users_page', [
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'project_id' => $project->id,
                ]) }}">See
                students</a>
            <a class="font-medium rounded-full min-w-[100px] text-center bg-blue-200 border hover:bg-blue-300 text-blue-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2"
                href="{{ route('project_modification_page', [
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'project_id' => $project->id,
                ]) }}">Edit</a>
            <button
                class="font-medium rounded-full min-w-[100px] text-center bg-red-200 border hover:bg-red-300 text-red-800 transition-all ease-in-out duration-200 border-gray-600 px-3 py-2"
                type="submit">Delete</button>
        </form>
    @endif

    {{-- Just student --}}
    @if (Auth::user()->hasRole(App\Enums\Roles::Student->value))
        <h4 class="mt-10 mb-2 text-2xl font-semibold">Upload Details</h4>
        <hr class="border-b-2 mb-5">

        <div class="grid grid-cols-2 gap-10">
            {{-- Upload form --}}
            <form
                action="{{ route('upload_creation', [
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'project_id' => $project->id,
                ]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <h4 class="mb-2 text-md font-semibold">Info</h4>
                    <hr class="border-b-2 mb-5">

                    <div class="flex flex-col gap-1 mb-5">
                        <label for="upload_title">Title</label>
                        <input class="rounded outline-none border border-gray-700 p-2" type="text" name="upload_title"
                            id="upload_title" value="{{ $upload->title ?? null }}">
                    </div>

                    <div class="flex flex-col gap-1 mb-5">
                        <label for="upload_description">Description</label>
                        <textarea class="rounded outline-none border border-gray-700 p-2" type="text" name="upload_description"
                            id="upload_description">{{ $upload->description ?? null }}</textarea>
                    </div>
                </div>

                <div class="mt-10">
                    <h4 class="mb-2 text-md font-semibold">Add Content</h4>
                    <hr class="border-b-2 mb-5">

                    {{-- Files --}}
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-md font-semibold">Files</h4>
                            <div id="file-create-button"
                                class="transition ease-in-out duration-200 inline-block ml-auto border border-gray-700 bg-gray-100 font-semibold text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-200">
                                Add</div>
                        </div>
                        <div id="file-create-field" class="flex flex-col gap-3 min-h-[50px]"></div>
                    </div>

                    {{-- Links --}}
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-md font-semibold">Links</h4>
                            <div id="link-create-button"
                                class="transition ease-in-out duration-200 inline-block ml-auto border border-gray-700 bg-gray-100 font-semibold text-gray-700 p-2 px-5 rounded-md cursor-pointer hover:bg-gray-200">
                                Add</div>
                        </div>
                        <div id="link-create-field" class="flex flex-col gap-3 min-h-[50px]"></div>
                    </div>
                </div>

                <div class="flex mt-5">
                    <button
                        class="transition ease-in-out duration-200 inline-block ml-auto border border-orange-700 bg-orange-300 font-semibold text-orange-700 p-2 px-5 rounded-md cursor-pointer hover:bg-orange-400"
                        type="submit">Upload</button>
                </div>
            </form>

            <div class="flex flex-col">
                <h4 class="mb-2 text-md font-semibold">Uploaded Content</h4>
                <hr class="border-b-2 mb-5">
                <div class="bg-gray-100 p-5 flex-auto border border-gray-800">
                    @if ($upload !== null)
                        {{-- Files --}}
                        <div class="mb-5">
                            <h4 class="font-semibold text-md">Files</h4>
                            <div class="grid grid-cols-4 gap-3 mt-3">
                                @foreach ($upload->files as $file)
                                    <div class="file-item transition ease-in-out duration-200 relative overflow-hidden"
                                        id="file-wrapper">
                                        <p
                                            class="file-title w-full text-sm text-white font-semibold hidden absolute top-3 left-0 px-2 z-50">
                                            {{ $file->title ?? null }}</p>
                                        <img class="file w-28 h-28" src="{{ asset('assets/img/uploaded-file.png') }}"
                                            alt="Photo" />

                                        <div class="file-actions-wrapper absolute bottom-0 right-0 flex">
                                            <form class="download-icon w-1/2"
                                                action="{{ route('upload_file_download', [
                                                    'course_id' => $course_id,
                                                    'lesson_id' => $lesson_id,
                                                    'project_id' => $project->id,
                                                    'file_id' => $file->id,
                                                ]) }}"
                                                method="POST">
                                                @csrf
                                                <button
                                                    class="p-2 w-full bg-gray-500 text-white cursor-pointer hover:bg-gray-600"
                                                    type="submit">
                                                    <i class="fa-solid fa-download"></i>
                                                </button>
                                            </form>
                                            <form class="delete-icon w-1/2"
                                                action="{{ route('upload_deletion', [
                                                    'course_id' => $course_id,
                                                    'lesson_id' => $lesson_id,
                                                    'project_id' => $project->id,
                                                    'document_id' => $file->id,
                                                ]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="file_id" value="{{ $file->id }}">
                                                <button
                                                    class="p-2 w-full bg-red-500 text-white cursor-pointer hover:bg-red-600"
                                                    type="submit">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Links --}}
                        <div>
                            <h4 class="font-semibold text-md mb-2">Links</h4>
                            <div class="flex flex-col gap-3">
                                @foreach ($upload->links as $link)
                                    <div id="link-wrapper"
                                        class="bg-orange-100 border border-orange-600 p-3 flex justify-between rounded-md">
                                        <a class="font-semibold underline" href="{{ $link->link }}"
                                            target="_blank">{{ $link->link }}</a>
                                        <form class="text-orange-600 font-semibold"
                                            action="{{ route('upload_deletion', [
                                                'course_id' => $course_id,
                                                'lesson_id' => $lesson_id,
                                                'project_id' => $project->id,
                                                'document_id' => $link->id,
                                            ]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="link_id" value="{{ $link->id }}">
                                            <input class="cursor-pointer" type="submit" value="Delete">
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($upload !== null)
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
            @endif
        </div>

        {{-- Files --}}
        <script>
            const fileCreateButton = document.getElementById('file-create-button');
            const fileFieldsContainer = document.getElementById('file-create-field');

            createNewFile();

            function addFileField() {
                createNewFile();
            }

            function createNewFile() {
                const fileContainer = document.createElement('div');
                fileContainer.classList.add('file-container');
                // [] is used to make Laravel understand that this is an array
                const fileTemplate = `
          <div class="flex justify-between bg-orange-100 border border-orange-700 items-center p-3 rounded-md">
            <input class="image-input" type="file" name="upload_file[]" placeholder="Upload file">
            <div class="file-delete-button text-orange-700 font-semibold cursor-pointer">Remove</div>
          </div>
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

            function createNewLink() {
                const linkContainer = document.createElement('div');
                linkContainer.classList.add('link-container');
                // [] is used to make Laravel understand that this is an array
                const linkTemplate = `
          <div class="flex justify-between bg-orange-100 border border-orange-700 items-center p-3 rounded-md">
            <input class="outline-none rounded p-1 px-3 border border-gray-800" type="link" name="upload_link[]" placeholder="URL">
            <div class="link-delete-button text-orange-700 font-semibold cursor-pointer">Remove</div>
          </div>
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

    <script>
        $(document).ready(function() {
            var $round = $('.round'),
                roundRadius = $round.find('circle').attr('r'),
                roundPercent = $round.data('percent'),
                roundCircum = 2 * roundRadius * Math.PI,
                roundDraw = roundPercent * roundCircum / 100
            $round.css('stroke-dasharray', roundDraw + ' 999')
        })
    </script>

@endsection
