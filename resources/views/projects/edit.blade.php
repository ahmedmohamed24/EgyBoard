@extends('layouts.app')
@section('title')
    Edit  
@endsection
@php
    $buttonText="edit";
@endphp
@section('content')
<h1 class="my-2 text-info text-center">Edit </h1>
<form method="POST" class="" action="{{ route('project.update',$project) }}">
    @method('PATCH')
    @include('projects._form')
   
@endsection