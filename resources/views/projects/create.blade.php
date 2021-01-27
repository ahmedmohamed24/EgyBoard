@extends('layouts.app')
@section('title')
    create  
@endsection
@section('content')
<h1 class="my-2 text-info text-center">Create new Project</h1>
<form method="POST" class="" action="{{ route('project.store') }}">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Project title">
        @error('title')
            <p class="alert alert-danger py-2 text-center">{{ $message }}</p>
        @enderror
    </div> 
    <div class="form-group">
      <label for="description">Description</label>
      <textarea  name="description" id="description" class="form-control" placeholder="project description" ></textarea>
        @error('description')
            <p class="alert alert-danger py-2 text-center">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Create</button>
        <a class="btn btn-secondary text-white" href="{{ route('project.all') }}">Cancel</a>
    </div>
</form>
@endsection