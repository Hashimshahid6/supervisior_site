@extends('layouts.master')
@section('title')
Banners
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Banners
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Banners List <span class="text-muted fw-normal ms-2">( {{ $banners->count()
                        }} )</span>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('banners.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
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
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Sub Heading</th>
                                    <th scope="col">Display On</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($banners as $banner)
                                <tr>
                                    <td>
                                        <img src="{{ URL::asset('public/images/banners/' . $banner->image) }}" 
                                        alt="Banner Image"
                                        class="img-thumbnail" style="width: 120px; height: auto;">
                                    </td>
                                    <td>{{ $banner->heading }}</td>
                                    <td>{{ $banner->subheading }}</td>
                                    <td>
                                        @if($banner->display_on == 'Home')
                                            <span class="btn btn-sm btn-primary">Home</span>
                                        @elseif($banner->display_on == 'About')
                                            <span class="btn btn-sm btn-info">About</span>
                                        @elseif($banner->display_on == 'Services')
                                            <span class="btn btn-sm btn-warning">Services</span>
                                        @elseif($banner->display_on == 'Contact')
                                            <span class="btn btn-sm btn-success">Contact</span>
                                        @elseif($banner->display_on == 'Pricing')
                                            <span class="btn btn-sm btn-danger">Pricing</span>
                                        @else
                                            <span class="btn btn-sm btn-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($banner->status == 'Active')
                                        <span class="btn btn-sm btn-success">Active</span>
                                        @elseif($banner->status == 'Inactive')
                                        <span class="btn btn-sm btn-warning">Inactive</span>
                                        @else
                                        <span class="btn btn-sm btn-danger">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('banners.edit', $banner->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete" class="px-2 text-danger"
                                                    onclick="deleteHeroSection({{ $banner->id }})"><i
                                                        class="bx bx-trash-alt font-size-18"></i></a>
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