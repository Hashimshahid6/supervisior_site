@extends('layouts.master')
@section('title')
Plant Checklists
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Plant Checklists
@endsection
@section('body')
<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Plant Checklist<span class="text-muted fw-normal ms-2">({{$DailyChecklists->count()}})</span></h5>
            </div>
        </div>
        @if(auth()->user()->role == 'Employee')
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <a href="{{route('plant_checklists.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>Add New</a>
            </div>
        </div>
        @endif
    </div>
    @include('components.flash_messages')
    <!-- end row -->
    <!-- Search Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('plant_checklists.index') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Search</label>
                                        <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}" placeholder="Search">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="project_id" class="form-label">Project</label>
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
                                    <label for="plant_type" class="form-label">Plant Type</label>
                                    <select class="form-select" name="plant_type">
                                        <option value="">Select Plant Type</option>
                                        @foreach($PlantTypes as $value)
                                        <option value="{{ $value }}" @if(request()->plant_type == $value) selected @endif>{{ $value }}</option>
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
                                        <option value="project_id" @if(request()->sort_by == 'project_id') selected @endif>Project</option>
                                        <option value="plant_type" @if(request()->sort_by == 'plant_type') selected @endif>Plant Type</option>
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
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('plant_checklists.index') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Plant Type</th>
                                    <th scope="col">Plant Details</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($DailyChecklists as $checklist)
                                <tr>
                                    <td>{{ @$checklist->project->name }}</td>
                                    <td>{{ $checklist->plant_type }}</td>
                                    <td>{{ $checklist->plant_details }}</td>
                                    <td><span class="badge bg-primary-subtle text-primary  mb-0">{{ $checklist->created_at->format('d M Y') }}</span></td>
                                    <td>
                                        @if($checklist->status == 'complete')
                                        <span class="badge bg-success-subtle text-dark mb-0">Completed</span>
                                        @elseif($checklist->status == 'incomplete')
                                        <span class="badge bg-warning-subtle text-warning mb-0">Incomplete</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                @if(auth()->user()->role == 'Employee')
                                                <a href="{{ route('plant_checklists.edit', $checklist->id) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                                @endif
                                                <a href="{{ route('plant_checklists.show', $checklist->id) }}" data-bs-toggle="tooltip"
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
                    {{ $DailyChecklists->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection