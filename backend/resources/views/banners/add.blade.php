@extends('layouts.master')
@section('title')
Services
@endsection
@section('css')
<!-- choices css -->
<link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- dropzone css -->
<link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
Services
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
                        <form action="{{route('banners.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div>
                                        <label class="form-label" for="heading">Heading <span
                                                class="text-danger">*</span></label>
                                        <input id="heading" name="heading" placeholder="Enter Heading" type="text"
                                            class="form-control">
                                        @error('heading')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="description">Sub Heading</label>
                                    <input id="subheading" name="subheading" placeholder="Enter Sub Heading" type="text"
                                        class="form-control">
                                    @error('subheading')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="display_on">Display On <span
                                            class="text-danger">*</span></label>
                                    <select id="display_on" name="display_on" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Home">Home</option>
                                        <option value="About">About</option>
                                        <option value="Services">Services</option>
                                        <option value="Contact">Contact</option>
                                    </select>
                                    @error('display_on')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                                <input type="file" id="image" name="image" class="form-control" />
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-success"> <i
                                            class="bx bx-check me-1"></i> Submit </button>
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