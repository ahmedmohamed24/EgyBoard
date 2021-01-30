@extends('layouts.app')
@section('title')
   {{ Str::limit($project->title, 15, '...') }} 
@endsection
@section('content')
    <header class="d-flex justify-content-between align-items-center py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('project.all') }}">my projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($project->title, 15, '...') }}</li>
            </ol>
        </nav>
    </header>
    <main class="row ">
        <div class="col-md-8">
            <div class="tasks-container">
                <h3 class="text-muted">Tasks</h3>
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <p class="alert alert-danger">{{ $item }}</p> 
                    @endforeach 
                @endif
                @forelse ($project->tasks as $task)
                    <div class="card shadow border-right-0 border-top-0 border-bottom-0 mb-2 border-primary">
                        <div class="card-body">
                            <form action="{{ route('task.update',[$project,$task]) }}" method="POST">
                                @method('patch')
                                @csrf
                                <div class="d-flex align-items-center pl-2">
                                    <input type="text" class="form-control border-0" value="{{ $task->body}}" name="body" placeholder="add new task ...">
                                    <input type="checkbox" onChange="this.form.submit()" class="form-check-input" @if ($task->status) checked @endif  name="status" >
                                </div>
                              
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="alert alert-warning my-3">no tasks found yet</p>    
                @endforelse
                <div class="card shadow border-right-0 border-top-0 border-bottom-0 mb-2 border-primary">
                    <div class="card-body">
                        <form action="{{ route('task.create',$project) }}" method="POST">
                            @csrf
                            <input type="text" class="form-control" name="body" placeholder="add new task ...">
                        </form>
                    </div>
                </div>
                <h4 class="text-muted mt-4 mb-3">General Notes</h4>
                <form method="POST" action="{{ route('project.update.notes',$project) }}">
                    @csrf
                    @method('patch')
                    <textarea name="notes" cols="30" rows="3" class="form-control" placeholder="@if ($project->notes == null) Add notes about your tasks @endif" >{{ $project->notes }}</textarea>
                    <button class="btn btn-info text-light mt-2 px-3" type="submit">save</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class=" project-desc-container mb-2">
                <div class="shadow bg-white py-4 bd-callout bd-callout-info pl-2 rounded" style="border-left:6px solid #5bc0de;min-height: 100%;">
                    <h4 id="dealing-with-specificity" class=""><a href="{{ $project->path() }}" class="text-decoration-none text-dark">{{$project->title }}</a></h4>
                    <p class="text-muted">
                        {{ $project->description }}
                    </p>
                    <a href="{{ route('project.edit',$project) }}" class="btn btn-primary text-white">Edit</a>
                </div> 
            </div>
            <div class="activity-container">
                @include('projects._activities')
            </div>
        </div>
    </main>
@endsection