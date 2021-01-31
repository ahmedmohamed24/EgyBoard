@extends('layouts.app')
@section('title')
    Activities 
@endsection
@section('content')
    <ul> 
        @foreach ($activities as $activity)
            <li>{{ $activity }}</li> 
        @endforeach
    </ul>
@endsection