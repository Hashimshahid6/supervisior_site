@extends('layouts.master')
@section('title')
Sections
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Sections
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Sections List <span class="text-muted fw-normal ms-2">( {{ $sections->count()
                        }} )</span>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('sections.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
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
                                    <th scope="col">Section Details</th>
                                    <th scope="col">Button</th>
                                    <th scope="col">Display On</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <!-- Section Details -->
                                    <td>
                                        <div class="d-flex align-items-start text-start">
                                            <!-- Image -->
                                            <img src="{{ URL::asset('public/images/sections/' . $section->image) }}" 
                                                 alt="Section Image" 
                                                 class="me-3 rounded" 
                                                 style="width: 100px; height: 80px; object-fit: cover;">
                    
                                            <!-- Details -->
                                            <div>
                                                <h5 class="mb-1">{{ $section->heading }}</h5>
                                                <h6 class="text-muted mb-1">{{ $section->subheading }}</h6>
                                                <p class="text-muted mb-0" style="max-width:500px">{{$section->content}}</p>
                                            </div>
                                        </div>
                                    </td>
                    
                                    <!-- Button Text -->
                                    <td>
                                        <a href="{{ $section->button_link }}" target="_blank" class="btn btn-sm btn-primary">
                                            {{ $section->button_text }}
                                        </a>
                                    </td>
                    
                                    <!-- Display On -->
                                    <td>
                                        @if($section->display_on == 'Home')
                                            <span class="btn btn-sm btn-primary">Home</span>
                                        @elseif($section->display_on == 'About')
                                            <span class="btn btn-sm btn-info">About</span>
                                        @elseif($section->display_on == 'Services')
                                            <span class="btn btn-sm btn-warning">Services</span>
                                        @elseif($section->display_on == 'Contact')
                                            <span class="btn btn-sm btn-success">Contact</span>
                                        @elseif($section->display_on == 'Pricing')
                                            <span class="btn btn-sm btn-danger">Pricing</span>
                                        @else
                                            <span class="btn btn-sm btn-secondary">Other</span>
                                        @endif
                                    </td>
                    
                                    <!-- Order -->
                                    <td><span class="btn btn-sm btn-info"> {{$section->order }}</span></td>
                    
                                    <!-- Status -->
                                    <td>
                                        @if($section->status == 'Active')
                                            <span class="btn btn-sm btn-success">Active</span>
                                        @elseif($section->status == 'Inactive')
                                            <span class="btn btn-sm btn-warning">Inactive</span>
                                        @else
                                            <span class="btn btn-sm btn-danger">Deleted</span>
                                        @endif
                                    </td>
                    
                                    <!-- Actions -->
                                    <td>
                                        <a href="{{ route('sections.edit', $section->id) }}" 
                                           class="text-primary me-2" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bx bx-pencil font-size-18"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-danger" 
                                           onclick="deleteHeroSection({{ $section->id }})" 
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