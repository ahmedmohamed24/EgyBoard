@extends('layouts.app')
@section('title')
    Projects 
@endsection
@section('content')
    <h1 class="text-info">All Projects <a href="{{ route('project.create') }}" class="btn btn-info">Create</a></h1>
    @if($projects->isEmpty())
        <p class="text-center fs-1 my-4 text-danger" style="font-size: 2rem">There is no PROJECTS yet</p>
    @else
    <div class="row border-box">
        @foreach ($projects as $project )
        <div class="card text-dark bg-light col-md-4 py-2 px-1 " style="">
            <div class="px-2  border-box" style="font-size: 1.2rem; border-left:5px solid #6cb2eb;"><a href="{{ $project->path() }}">{{ $project->title }}</a></div>
            <div class="card-body border-box">
                <p class="card-text text-muted">{{ $project->description }}</p>
            </div>
        </div> 
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center align-items-center">{{ $projects->links() }}</div>
    @endif
   
    
@endsection