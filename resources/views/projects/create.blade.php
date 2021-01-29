@extends('layouts.app')
@section('title')
    create  
@endsection
@php
    $project=new \App\Models\Project;
    $buttonText="create";
@endphp
@section('content')
<h1 class="my-2 text-info text-center">Let's add new Thing</h1>
<form method="POST" class="" action="{{ route('project.store') }}">
    @include('projects._form')
   
@endsection