@extends('base')

@section('content')
  <h1>Students for this project</h1>
  <ul>
    @foreach ($students as $student)
      <li>
        {{-- <a href="{{route('user_details_page', ['user_id' => $user->id])}}">
          {{$user->name}}
        </a> --}}
        <p>{{$student->name}} | Falta poner notas, etc</p>
      </li>
    @endforeach
  </ul>
@endsection