@extends('layouts.master')
@section('title')
Edit Hero Section
@endsection
@section('css')
<!-- choices css -->
<link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- dropzone css -->
<link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
Edit Hero Section
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="card">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                        <h5 class="text-primary font-size-17 mb-0">S</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Item Info</h5>
                                <p class="text-muted text-truncate mb-0">Fill all information below</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top">
                        <form action="{{route('hero_sections.update', $heroSection->id)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="productname">Title <span
                                        class="text-danger">*</span></label>
                                <input id="title" name="title" placeholder="Enter Title" type="text"
                                    class="form-control" value="{{ $heroSection->title }}">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="subtitle">Subtitle/Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="subtitle" name="subtitle"
                                    placeholder="Enter Subtitle" rows="4">{{ $heroSection->subtitle }}</textarea>
                                @error('subtitle')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="button_text">Button Text <span
                                                class="text-danger">*</span></label>
                                        <input id="button_text" name="button_text" placeholder="Enter Button Text"
                                            type="text" class="form-control" value="{{ $heroSection->button_text }}">
                                        @error('button_text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="button_url">Button URL <span
                                                class="text-danger">*</span></label>
                                        <input id="button_url" name="button_url" placeholder="Enter Button URL"
                                            type="text" class="form-control" value="{{ $heroSection->button_url }}">
                                        @error('button_url')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                        <select id="status_edit" name="status" class="form-select">
                                            <option value="Active" {{ $heroSection->status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $heroSection->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="Deleted" {{ $heroSection->status == 'Deleted' ? 'selected' : '' }}>Deleted</option>
                                        </select>
                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                                <input type="file" id="image" name="image" class="form-control" />
                                @if($heroSection->image)
                                <img src="{{ asset('public/images/hero-section/' . $heroSection->image) }}" alt="Current Image"
                                    class="img-thumbnail mt-2" width="150">
                                @endif
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-success"> <i class="bx bx-check me-1"></i>
                                        Save Changes </button>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection
    @section('scripts')
    <!-- choices js -->
    <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- dropzone plugin -->
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/ecommerce-choices.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection