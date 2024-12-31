@extends('layouts.master')
@section('title')
Packages
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Packages
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Packages List <span class="text-muted fw-normal ms-2">( {{ $packages->count()
                        }} )</span></h5>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('packages.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
                        Add New</a>
                </div>
            </div>

        </div>
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
                                    <th scope="col">Package Details</th>
                                    <th>Upload Limit</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $package)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start text-start">
                                            <!-- Title and Description -->
                                            <div>
                                                <h6 class="mb-1">{{ $package->name }}</h6>
                                                <p class="font-bold mb-0">£{{ $package->price }}</p>
                                                <p class="text-semibold mb-0">{{ $package->trial_text }}</p>
                                                <p class="text-muted mb-0">{{ $package->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm btn-primary">{{ $package->project_limit }}</span>
                                    </td>
                                    <td>
                                        @if($package->status == 'Active')
                                        <span class="btn btn-sm btn-success">Active</span>
                                        @elseif($package->status == 'Inactive')
                                        <span class="btn btn-sm btn-danger">Inactive</span>
                                        @else
                                        <span class="btn btn-sm btn-warning">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('packages.edit', $package->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
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