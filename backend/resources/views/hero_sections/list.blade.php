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
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Button</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($heroSections as $heroSection)
                                <tr>
                                    <td>
                                        <img src="{{ URL::asset('public/images/hero-section/' . $heroSection->image) }}" 
                                        alt="Hero Image"
                                        class="rounded" style="width: 100px; height: auto;">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-start text-start">
                                            <div>
                                                <h6 class="mb-1">{{ $heroSection->title }}</h6>
                                                <h6 class="text-muted mb-1" style="max-width:600px">{{ $heroSection->subtitle }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ $heroSection->button_link }}" target="_blank" class="btn btn-sm btn-primary">
                                            {{ $heroSection->button_text }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($heroSection->status == 'Active')
                                        <span class="btn btn-sm btn-success">Active</span>
                                        @elseif($heroSection->status == 'Inactive')
                                        <span class="btn btn-sm btn-warning">Inactive</span>
                                        @else
                                        <span class="btn btn-sm btn-danger">Deleted</span>
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