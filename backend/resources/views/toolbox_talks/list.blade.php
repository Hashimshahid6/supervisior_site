@extends('layouts.master')
@section('title')
Toolbox Talks
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Toolbox Talks
@endsection
@section('body')
<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Toolbox Talks Template List<span class="text-muted fw-normal ms-2">({{$toolboxTalks->count()}})</span></h5>
            </div>
        </div>
        @if(auth()->user()->role == 'Employee')
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <a href="{{route('toolbox_talks.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>Add New</a>
            </div>
        </div>
        @endif
    </div>
    @include('components.flash_messages')
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
                                    <td>{{ $toolboxTalk->project->name }}</td>
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
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection