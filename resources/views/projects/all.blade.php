@extends('layouts.app')
@section('title')
    Projects 
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h4 class="text-muted">My Projects</h4>
        <a  href="{{ route('project.create') }}" class="btn btn-info text-light">New Project</a>
    </div>
    @if($projects->isEmpty())
        <p class="text-center fs-1 my-4 text-danger" style="font-size: 2rem">There is no PROJECTS yet</p>
    @else
    <div class="row">
        <div class="col-md-10 row">
            @forelse($projects as $project )
            <div class="col-md-4  mb-2">
                <div class="shadow bg-white py-3 bd-callout bd-callout-info pl-2 rounded" style="border-left:6px solid #5bc0de;min-height: 100%;">
                    <h4 id="dealing-with-specificity" class=""><a href="{{ $project->path() }}" class="text-decoration-none text-dark">{{ Str::limit($project->title,25, '...')  }}</a></h4>
                    <p class="text-muted">
                        {{ Str::limit($project->description, 250, '...') }}
                    </p>
                </div> 
            </div>
            @empty 
                <h2 class="alert alert-warning">Let's add new projects and start working</h2>
            @endforelse
        </div>
        <div class="col-md-2">
            @include('projects._activities ') 
        </div>
    </div> 
    <div class="mt-4 d-flex justify-content-center align-items-center">{{ $projects->links() }}</div>
    @endif
   
    
@endsection