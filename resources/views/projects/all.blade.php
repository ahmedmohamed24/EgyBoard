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
        @foreach ($projects as $project )

        <div class="col-md-4  mb-2">
            <div class="shadow bg-white py-4 bd-callout bd-callout-info pl-2 rounded" style="border-left:6px solid #5bc0de;min-height: 100%;">
                <h4 id="dealing-with-specificity" class=""><a href="{{ $project->path() }}" class="text-decoration-none text-dark">{{ Str::limit($project->title,25, '...')  }}</a></h4>
                <p class="text-muted">
                    {{ Str::limit($project->description, 250, '...') }}
                </p>
            </div> 
        </div>
        {{-- <div class="col-md-4">
            <div class="card  shadow bg-white py-3 pr-1 mb-2 ml-1" style="">
                <div class="px-2 py-2 " style="font-size: 1.2rem; border-left:6px solid #91c5f0;"><a href="{{ $project->path() }}" class="text-decoration-none text-black">{{ Str::limit($project->title,25, '...')  }}</a></div>
                <div class="card-body ">
                    <p class="card-text text-muted">{{ Str::limit($project->description, 250, '...') }}</p>
                </div>
            </div> 
        </div> --}}
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center align-items-center">{{ $projects->links() }}</div>
    @endif
   
    
@endsection