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
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($DailyChecklists as $checklist)
                                <tr>
                                    <td>{{ $checklist->project->name }}</td>
                                    <td>{{ $PlantTypes[$checklist->plant_type] ?? 'Unknown' }}</td>
                                    <td>
                                        @if($checklist->status == 'complete')
                                        <span class="badge bg-success text-white">Completed</span>
                                        @elseif($checklist->status == 'incomplete')
                                        <span class="badge bg-warning text-dark">Incomplete</span>
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
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection