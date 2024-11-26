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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Sub Heading</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Button Text</th>
                                    <th scope="col">Button Link</th>
                                    <th scope="col">Display On</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ URL::asset('public/images/sections/' . $section->image) }}" target="_blank">
                                            <i class="bx bx-image" style="font-size: 24px;"></i>
                                        </a>
                                    </td>
                                    <td>{{ $section->heading }}</td>
                                    <td>{{ $section->subheading }}</td>
                                    <td>{{ $section->content }}</td>
                                    <td>{{ $section->button_text }}</td>
                                    <td>
                                        <a href="{{ $section->button_link }}" target="_blank">
                                            <i class="bx bx-link-alt" style="font-size: 20px;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($section->display_on == 'Home')
                                        <span class="badge bg-primary">Home</span>
                                        @elseif($section->display_on == 'About')
                                        <span class="badge bg-info">About</span>
                                        @elseif($section->display_on == 'Services')
                                        <span class="badge bg-warning">Services</span>
                                        @elseif($section->display_on == 'Contact')
                                        <span class="badge bg-success">Contact</span>
                                        @elseif($section->display_on == 'Pricing')
                                        <span class="badge bg-danger">Pricing</span>
                                        @else
                                        <span class="badge bg-danger">Other</span>
                                        @endif
                                    </td>
                                    <td>{{ $section->order }}</td>
                                    <td>
                                        @if($section->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                        @elseif($section->status == 'Inactive')
                                        <span class="badge bg-warning">Inactive</span>
                                        @else
                                        <span class="badge bg-danger">Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('sections.edit', $section->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete" class="px-2 text-danger"
                                                    onclick="deleteHeroSection({{ $section->id }})"><i
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