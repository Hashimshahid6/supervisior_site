@extends('layouts.master')
@section('title')
Toolbox Talks
@endsection
@section('page-title')
Toolbox Talks
@endsection
@section('body')
<body>
    @endsection
    @section('content')
    @include('components.flash_messages')
    <!-- Search Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->role == 'Employee')
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            <a href="{{route('toolbox_talks.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>Add New</a>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('toolbox_talks.index') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" id="search" name="search" value="{{ request()->search }}"
                                        placeholder="Search">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="project_id" class="form-label">Projects</label>
                                    <select class="form-select" name="project_id">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->id }}" @if(request()->project_id == $project->id) selected @endif>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="complete" @if(request()->status == 'complete') selected @endif>Complete</option>
                                        <option value="incomplete" @if(request()->status == 'incomplete') selected @endif>Incomplete</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="sort_by" class="form-label">Sort By</label>
                                    <select class="form-select" name="sort_by">
                                        <option value="id" @if(request()->sort_by == 'id') selected @endif>ID</option>
                                        <option value="topic" @if(request()->sort_by == 'topic') selected @endif>Topic</option>
                                        <option value="presented_by" @if(request()->sort_by == 'presented_by') selected @endif>Talk Person</option>
                                        <option value="project_id" @if(request()->sort_by == 'project_id') selected @endif>Project</option>
                                        <option value="status" @if(request()->sort_by == 'status') selected @endif>Status</option>
                                        <option value="created_at" @if(request()->sort_by == 'created_at') selected @endif>Created At</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <select class="form-select" name="sort_order">
                                        <option value="desc" @if(request()->sort_order == 'desc') selected @endif>Descending</option>
                                        <option value="asc" @if(request()->sort_order == 'asc') selected @endif>Ascending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="per_page" class="form-label">Per Page</label>
                                    <select class="form-select" id="per_page" name="per_page">
                                        <option value="10" @if(request()->per_page == '10') selected @endif>10</option>
                                        <option value="25" @if(request()->per_page == '25') selected @endif>25</option>
                                        <option value="50" @if(request()->per_page == '50') selected @endif>50</option>
                                        <option value="100" @if(request()->per_page == '100') selected @endif>100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 mt-4">
                                    <label for="search" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('toolbox_talks.index') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end search filters -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Talk Person</th>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($toolboxTalks as $toolboxTalk)
                                <tr>
                                    <td>{{ $toolboxTalk->topic }}</td>
                                    <td>{{ $toolboxTalk->presented_by }}</td>
                                    <td>{{ @$toolboxTalk->project->name }}</td>
                                    <td>
                                        @if($toolboxTalk->status == 'complete')
                                        <span class="badge bg-success text-white">Completed</span>
                                        @elseif($toolboxTalk->status == 'incomplete')
                                        <span class="badge bg-warning text-dark">Incomplete</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                @if(auth()->user()->role == 'Employee')
                                                <a href="{{ route('toolbox_talks.edit', $toolboxTalk->id) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                                @endif
                                                <a href="{{ route('toolbox_talks.show', $toolboxTalk->id) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View" class="px-2 text-success"><i
                                                        class="bx bx-show font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $toolboxTalks->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection