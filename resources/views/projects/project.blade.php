@extends('layouts.app')
@section('title')
   {{ Str::limit($project->title, 15, '...') }} 
@endsection
@section('content')
    <h1  class="text-info">{{ $project->title }}</h1> 
    <p>{{ $project->description}}</p> 
@endsection