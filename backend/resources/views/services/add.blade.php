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
                        <form action="{{route('services.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="productname">Title <span
                                        class="text-danger">*</span></label>
                                <input id="title" name="title" placeholder="Enter Title" type="text"
                                    class="form-control">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="subtitle">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter Subtitle" rows="4"></textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="button_text">Button Text <span
                                                class="text-danger">*</span></label>
                                        <input id="button_text" name="button_text" placeholder="Enter Button Text"
                                            type="text" class="form-control">
                                        @error('button_text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="button_url">Button URL <span
                                                class="text-danger">*</span></label>
                                        <input id="button_url" name="button_url" placeholder="Enter Button URL"
                                            type="text" class="form-control">
                                        @error('button_url')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="icon">Icon <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="icon" name="icon" class="form-control" />
                                @error('icon')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bgImage">Background Image <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="bgImage" name="bgImage" class="form-control" />
                                @error('bgImage')
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