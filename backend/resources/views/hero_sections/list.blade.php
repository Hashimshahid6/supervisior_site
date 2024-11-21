@extends('layouts.master')
@section('title')
Hero Section
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Hero Section
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div id="priceslider" class="mb-4"></div>
                <div class="card-body py-5">
                    <div class="swiper-container slider rounded overflow-hidden">
                        <div class="swiper-wrapper" dir="ltr">
                            @foreach($heroSections as $heroSection)
                            <div class="swiper-slide rounded overflow-hidden ecommerce-slied-bg">
                                <div class="row justify-content-center">
                                    <div class="col-xl-11 col-lg-11">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="p-4 p-xl-0 text-center">
                                                    <img src="{{ URL::asset('images/hero-section/' . $heroSection->image) }}" class="img-fluid rounded shadow-sm" alt="" style="max-height: 300px; object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-4 p-xl-0">
                                                    <h3 class="mb-2"><a href="javascript:void(0);">{{ $heroSection->title }}</a></h3>
                                                    <h5 class="fw-normal font-size-16 mt-1">{{ $heroSection->subtitle }}</h5>
                                                    <div class="mt-4">
                                                        <a href="{{ $heroSection->button_url }}" class="btn btn-success w-lg waves-effect waves-light">{{ $heroSection->button_text }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-none d-lg-block">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Sliders List <span class="text-muted fw-normal ms-2">( {{ $heroSections->count()
                        }} )</span>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('hero_sections.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
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
                                    <th scope="col">Title</th>
                                    <th scope="col">Subtitle</th>
                                    <th scope="col">Button Text</th>
                                    <th scope="col">Button Url</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($heroSections as $heroSection)
                                <tr>
                                    <td>
                                        <a href="{{ URL::asset('images/hero-section/' . $heroSection->image) }}" target="_blank">
                                            <i class="bx bx-image" style="font-size: 24px;"></i>
                                        </a>
                                    </td>
                                    <td>{{ $heroSection->title }}</td>
                                    <td>{{ $heroSection->subtitle }}</td>
                                    <td>{{ $heroSection->button_text }}</td>
                                    <td>
                                        <a href="{{ $heroSection->button_url }}" target="_blank">
                                            <i class="bx bx-link-alt" style="font-size: 20px;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($heroSection->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                        @elseif($heroSection->status == 'Inactive')
                                        <span class="badge bg-warning">Inactive</span>
                                        @else
                                        <span class="badge bg-danger">Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('hero_sections.edit', $heroSection->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete" class="px-2 text-danger"
                                                    onclick="deleteHeroSection({{ $heroSection->id }})"><i
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