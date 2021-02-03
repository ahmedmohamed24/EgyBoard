@extends('layouts.app')
@section('title')
    {{ Str::limit($project->title, 15, '...') }}
@endsection
@section('content')

    <main class="row ">
        <div class="col-md-8">
            <div class="tasks-container">
                <header class="d-flex justify-content-between align-items-center py-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white">
                            <li class="breadcrumb-item"><a href="{{ route('project.all') }}">my projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ Str::limit($project->title, 15, '...') }}</li>
                        </ol>
                    </nav>
                    @foreach ($project->members as $member)
                        <img src="" alt=""> 
                    @endforeach 
                </header>
                <h3 class="text-muted">Tasks</h3>
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <p class="alert alert-danger">{{ $item }}</p>
                    @endforeach
                @endif
                @forelse ($project->tasks as $task)
                    <div class="card shadow border-right-0 border-top-0 border-bottom-0 mb-2 border-primary ">
                        <div class="card-body ">
                            <form action="{{ route('task.update', [$project, $task]) }}" method="POST">
                                @method('patch')
                                @csrf
                                @if ($task->status)
                                    <del>
                                @endif
                                <div class="d-flex align-items-center pl-2 ">
                                    <input type="text" class="form-control border-0 " value="{{ $task->body }}" name="body"
                                        placeholder="add new task ...">
                                    <input type="checkbox" onChange="this.form.submit()" class="form-check-input" @if ($task->status) checked @endif
                                        name="status">
                                </div>
                                @if ($task->status)
                                    </del>
                                @endif

                            </form>
                        </div>
                    </div>
                @empty
                    <p class="alert alert-warning my-3">no tasks found yet</p>
                @endforelse
                <div class="card shadow border-right-0 border-top-0 border-bottom-0 mb-2 border-primary">
                    <div class="card-body">
                        <form action="{{ route('task.create', $project) }}" method="POST">
                            @csrf
                            <input type="text" class="form-control" name="body" placeholder="add new task ...">
                        </form>
                    </div>
                </div>
                <h4 class="text-muted mt-4 mb-3">General Notes</h4>
                <form method="POST" action="{{ route('project.update.notes', $project) }}">
                    @csrf
                    @method('patch')
                    <textarea name="notes" cols="30" rows="3" class="form-control" placeholder="@if ($project->notes == null) Add notes about your tasks @endif" >{{ $project->notes }}</textarea>
                    <button class="btn btn-info text-light mt-2 px-3" type="submit">save</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class=" project-desc-container mb-2">
                <div class="shadow bg-white py-4 bd-callout bd-callout-info pl-2 rounded"
                    style="border-left:6px solid #5bc0de;min-height: 100%;">
                    <h4 id="dealing-with-specificity" class=""><a href="{{ $project->path() }}"
                            class="text-decoration-none text-dark">{{ $project->title }}</a></h4>
                    <p class="text-muted">
                        {{ $project->description }}
                    </p>

                    <button type="button" class="btn " data-toggle="modal" data-target="#editModal">
                        <img src="{{ asset('images/edit.svg') }}" alt="edit icon">
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inviteModal">
                        Invite Users
                    </button>

                    {{-- start edit project --}}
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @php
                                        $buttonText = 'edit';
                                    @endphp
                                    <form method="POST" action="{{ route('project.update', $project) }}">
                                        @method('PATCH')
                                        @include('projects._form')
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end edit project --}}

                    {{-- start invite users to project --}}
                    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-info" id="exampleModalLabel">Invite users and start
                                        collaborating</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('project.invite', $project) }}" method="POST">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <label for="invitee" class="text-secondary">Email of the Invitee</label>
                                            <input type="text" name="email" id="invitee" class="form-control"
                                                placeholder="person@example.com">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Invite</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- end invite users to project --}}

                </div>
                <div class="activity-container">
                    @include('projects._activities')
                </div>
            </div>
    </main>
@endsection
