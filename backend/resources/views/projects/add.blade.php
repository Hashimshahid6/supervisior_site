@extends('layouts.master')
@section('title')
Packages
@endsection
@section('css')
<!-- choices css -->
<link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- dropzone css -->
<link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
Packages
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
                        <form action="{{route('packages.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Package Name <span
                                                class="text-danger">*</span></label>
                                        <input id="name" name="name" placeholder="Enter Name" type="text"
                                            class="form-control">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Price <span
                                                class="text-danger">*</span></label>
                                        <input id="price" name="price" placeholder="Enter Price" type="text"
                                            class="form-control">
                                        @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="description">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea id="description" name="description" class="form-control"
                                            placeholder="Enter Description" rows="3"></textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="trial_text">Trial Text <span
                                                class="text-danger">*</span></label>
                                        <input id="trial_text" name="trial_text" placeholder="Enter Trial Text" type="text"
                                            class="form-control">
                                        @error('trial_text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-success"> <i class="bx bx-check me-1"></i>
                                        Submit </button>
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