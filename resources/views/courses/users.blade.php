@extends('base')

@section('title', 'Linked Students')

@section('content')
    @if (session('user_unlink_info'))
        <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{session('user_unlink_info')}}</span>
        </div>
    @endif
    @if (session('user_link_info'))
        <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{session('user_link_info')}}</span>
        </div>
    @endif

    <h3 class="text-4xl font-semibold">Students of this course</h3>

    <div>
        <div class="mt-10 mb-5">
            <p class="mb-1">Filters: </p>
            <form class="bg-gray-100 p-5 border border-gray-500 rounded-md"
                action="{{ route('course_users_page', [
                    'course_id' => $course_id,
                ]) }}"
                method="GET">
                <div class="inline-flex flex-col">
                    <label class="mb-1" for="search-field">Search by name:</label>
                    <div class="flex gap-3">
                        <div class="inline-flex bg-white border border-gray-600 rounded p-1">
                            <input class="outline-none px-1" id="search-field" type="text" name="search"
                                value="{{ request()->search }}">
                            <button class="px-1" id="search-button" type="submit" disabled>
                              <i class="fas fa-search"></i>
                            </button>
                        </div>
                        @if (request()->search)
                            <a class="bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-200 text-orange-100 py-1 px-3 rounded-md font-semibold"
                                href="{{ route('course_users_page', [
                                    'course_id' => $course_id,
                                ]) }}">Clear</a>
                        @endif
                    </div>
                </div>

                {{-- Errors --}}
                @error('search')
                    <div class="mt-2 text-red-500 font-semibold">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>

    <form class="mt-10" action="{{ route('course_link_users', ['course_id' => $course_id]) }}" method="POST">
        @csrf

        <input type="hidden" name="course_id" value="{{ $course_id }}">
        <input class="border border-gray-600 rounded py-1 px-2 outline-none mr-2" type="email" name="user_email" placeholder="Student email">
        <button class="bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-200 text-orange-100 py-1 px-3 rounded-md font-semibold" type="submit">Add</button>
      
        {{-- Errors --}}
        @error('user_email')
            <div class="mt-2 text-red-500 font-semibold">{{ $message }}</div>
        @enderror
      </form>

    <div class="flex flex-col gap-2 mt-10">
        @forelse ($students as $student)
            <div class="bg-orange-100 border border-orange-600 flex justify-between p-3 font-semibold rounded-md">
                <p>{{ $student->name }} - <span class="font-normal">{{ $student->email }}</span></p>
                <form
                    action="{{ route('course_unlink_users', [
                        'course_id' => $course_id,
                        'user_id' => $student->id,
                    ]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                    <button class="text-orange-600" type="submit">Remove</button>
                </form>
            </div>
        @empty
            <div>
              <p>No results found.</p>
            </div>
        @endforelse
    </div>
    {{-- Add user --}}

    <script>
        const searchField = document.getElementById('search-field');
        const searchButton = document.getElementById('search-button');

        searchField.addEventListener('input', () => {
            // Min 3 chars to use the search bar
            if (searchField.value.length > 0) {
                searchButton.disabled = false;
            } else {
                searchButton.disabled = true;
            }
        });
    </script>
@endsection
