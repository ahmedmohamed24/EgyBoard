@extends('layouts.app')
@section('title')
    Edit  
@endsection
@php
    $buttonText="edit";
@endphp
@section('content')
    <header class="d-flex justify-content-between align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('project.all') }}">my projects</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('project.show',$project) }}">{{ Str::limit($project->title, 15, '...') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </header>
<h1 class="mb-2 text-info text-center">Edit </h1>
<form method="POST" class="" action="{{ route('project.update',$project) }}">
    @method('PATCH')
    @include('projects._form')
   
@endsection