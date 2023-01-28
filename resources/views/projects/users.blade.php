@extends('base')

@section('title', 'Students for this project')

@section('content')
    <h3 class="text-4xl font-semibold">Students for this project</h3>

    <div class="mt-10 mb-5">
        <p class="mb-1">Filters: </p>
        <form class=" bg-gray-100 p-5 border border-gray-500 rounded-md"
            action="{{ route('project_users_page', [
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'project_id' => $project_id,
                'search' => request()->search,
                'order_by' => request()->order_by,
                'order' => request()->order,
            ]) }}"
            method="GET">
            <label class="mb-1" for="search-field">Search by name:</label>
            <div class="flex items-center gap-5">
                <div class="flex gap-3">
                    <div class="inline-flex bg-white border border-gray-600 rounded p-1">
                        <input class="outline-none px-1" id="search-field" type="text" name="search"
                            value="{{ request()->search }}">

                        <button class="px-1" id="search-button" type="submit" disabled>
                          <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @if (request()->search)
                        <a class="bg-gray-500 hover:bg-gray-600 transition-all ease-in-out duration-200 text-gray-100 py-1 px-3 rounded-md font-semibold"
                            href="{{ route('project_users_page', [
                                'course_id' => $course_id,
                                'lesson_id' => $lesson_id,
                                'project_id' => $project_id,
                                'order_by' => request()->order_by,
                                'order' => request()->order,
                            ]) }}">Clear</a>
                    @endif
                </div>

                {{-- Order by mark --}}
                <div>
                    <a class="h-full inline-block bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-200 text-orange-100 py-1 px-3 rounded-md font-semibold"
                        href="{{ route('project_users_page', [
                            'course_id' => $course_id,
                            'lesson_id' => $lesson_id,
                            'project_id' => $project_id,
                            'search' => request()->search,
                            'order_by' => 'mark',
                            'order' => 'asc',
                        ]) }}">Order
                        by mark ASC</a>

                    <a class="h-full inline-block bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-200 text-orange-100 py-1 px-3 rounded-md font-semibold"
                        href="{{ route('project_users_page', [
                            'course_id' => $course_id,
                            'lesson_id' => $lesson_id,
                            'project_id' => $project_id,
                            'search' => request()->search,
                            'order_by' => 'mark',
                            'order' => 'desc',
                        ]) }}">Order
                        by mark DESC</a>

                    @if (request()->order_by === 'mark' && (request()->order === 'asc' || request()->order === 'desc'))
                        <a
                        class="h-full inline-block bg-gray-500 hover:bg-gray-600 transition-all ease-in-out duration-200 text-gray-100 py-1 px-3 rounded-md font-semibold""
                            href="{{ route('project_users_page', [
                                'course_id' => $course_id,
                                'lesson_id' => $lesson_id,
                                'project_id' => $project_id,
                                'search' => request()->search,
                            ]) }}">Clear
                            order by mark</a>
                    @endif
                </div>
            </div>

            {{-- Errors --}}
            @error('search')
                <div class="text-red-500 font-semibold mt-2">{{ $message }}</div>
            @enderror
        </form>

        @if (request()->search)
            <a
                href="{{ route('project_users_page', [
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'project_id' => $project_id,
                    'order_by' => request()->order_by,
                    'order' => request()->order,
                ]) }}">Clear</a>
        @endif
    </div>

    <div class="flex flex-col gap-3">
        @forelse ($students as $student)
            <div class="flex items-center justify-between gap-5 font-semibold border border-orange-600 bg-orange-100 p-3 rounded-md">
                <div class="flex gap-10">
                  <p class="inline-flex w-[400px]" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                    {{ $student->name }} <span class="font-normal">- {{ $student->email }}</span>
                  </p>
                  
                  {{-- When student has already a mark --}}
                  <div>
                      <form
                          action="{{ route('project_evaluate', [
                              'course_id' => $course_id,
                              'lesson_id' => $lesson_id,
                              'project_id' => $project_id,
                              'user_id' => $student->id,
                          ]) }}"
                          method="POST">
                          @csrf
                          @method('PUT')
                  
                          <input class="p-1 outline-none rounded font-normal" type="number" name="mark" step="0.00001"
                              value="{{ $student->marks->firstWhere('project_id', $project_id)->mark ?? '' }}">
                  
                          {{-- Errors --}}
                          @if ($errors->any())
                              <div>{{ $errors->first() }}</div>
                          @endif
                  
                          <button class="ml-2 h-full inline-block bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-200 text-orange-100 py-1 px-3 rounded-md font-semibold" type="submit">Update mark</button>
                      </form>
                  </div>
                </div>

                <a
                class="h-full inline-block font-semibold text-orange-500"
                    href="{{ route('project_user_details_page', [
                        'course_id' => $course_id,
                        'lesson_id' => $lesson_id,
                        'project_id' => $project_id,
                        'user_id' => $student->id,
                    ]) }}">See
                    uploads</a>
            </div>
        @empty
            <div>No students</div>
        @endforelse
    </div>

    <script>
        const searchField = document.getElementById('search-field');
        const searchButton = document.getElementById('search-button');

        searchField.addEventListener('input', () => {
            // Min 3 chars to use the search bar
            if (searchField.value.length > 3) {
                searchButton.disabled = false;
            } else {
                searchButton.disabled = true;
            }
        });
    </script>

@endsection
