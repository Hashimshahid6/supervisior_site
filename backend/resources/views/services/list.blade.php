@extends('layouts.master')
@section('title')
Services
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Services
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Services List <span class="text-muted fw-normal ms-2">( {{ $services->count()
                        }} )</span>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('services.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
                        Add New</a>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Background Image</th>
                                    <th scope="col">Service Details</th>
                                    <th scope="col">Button</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @foreach($services as $service)
                                <tr>
                                    <!-- Background Image -->
                                    <td>
                                        <img src="{{ URL::asset('public/images/services/' . $service->bgImage) }}" 
                                             alt="Background Image" 
                                             class="img-thumbnail" style="width: 120px; height: auto;">
                                    </td>
                    
                                    <!-- Service Details -->
                                    <td>
                                        <div class="d-flex align-items-start text-start">
                                            <!-- Icon -->
                                            <img src="{{ URL::asset('public/images/services/' . $service->icon) }}" 
                                                 alt="Icon" 
                                                 class="me-3 img-fluid rounded" 
                                                 style="width: 50px; height: 50px;">
                    
                                            <!-- Title and Description -->
                                            <div>
                                                <h6 class="mb-1">{{ $service->title }}</h6>
                                                <p class="text-muted mb-0" style="max-width: 350px;">
                                                    {{ \Illuminate\Support\Str::limit($service->description, 80, '...') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                    
                                    <!-- Button Text -->
                                    <td>
                                        <a href="{{ $service->button_url }}" target="_blank" class="btn btn-sm btn-primary">
                                            {{ $service->button_text }}
                                        </a>
                                    </td>
                    
                                    <!-- Status -->
                                    <td>
                                        @if($service->status == 'Active')
                                            <span class="btn btn-sm btn-success">Active</span>
                                        @elseif($service->status == 'Inactive')
                                            <span class="btn btn-sm btn-danger">Inactive</span>
                                        @else
                                            <span class="btn btn-sm btn-warning">Deleted</span>
                                        @endif
                                    </td>
                    
                                    <!-- Actions -->
                                    <td>
                                        <a href="{{ route('services.edit', $service->id) }}" 
                                           class="text-primary me-2" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bx bx-pencil font-size-18"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-danger" 
                                           onclick="deleteHeroSection({{ $service->id }})" 
                                           data-bs-toggle="tooltip" title="Delete">
                                            <i class="bx bx-trash-alt font-size-18"></i>
                                        </a>
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
    @section('scripts')
    <!-- swiper js -->
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- nouisliderribute js -->
    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/product-filter-range.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection