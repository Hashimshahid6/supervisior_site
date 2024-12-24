@extends('layouts.master')
@section('title')
Website Settings
@endsection
@section('css')
<!-- choices css -->
<link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- dropzone css -->
<link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
Website Settings
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
                        <form action="{{route('website_settings.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_name">Site Name <span
                                                class="text-danger">*</span></label>
                                        <input id="site_name" name="site_name" placeholder="Enter Site Name" type="text"
                                            class="form-control">
                                        @error('site_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_url">Site URL <span
                                                class="text-danger">*</span></label>
                                        <input id="site_url" name="site_url" placeholder="Enter Site URL" type="text"
                                            class="form-control">
                                        @error('site_url')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_email">Email <span class="text-danger">*</span></label>
                                        <input id="site_email" name="site_email" placeholder="Enter Site Email" type="email" class="form-control">
                                        @error('site_email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_email2">Email 2</label>
                                        <input id="site_email2" name="site_email2" placeholder="Enter Site Email 2" type="email" class="form-control">
                                        @error('site_email2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_phone">Site Phone <span class="text-danger">*</span></label>
                                        <input id="site_phone" name="site_phone" placeholder="Enter Site Phone" type="text" class="form-control">
                                        @error('site_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_phone2">Phone 2</label>
                                        <input id="site_phone2" name="site_phone2" placeholder="Enter Site Phone 2" type="text" class="form-control">
                                        @error('site_phone2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_address">Address <span class="text-danger">*</span></label>
                                        <input id="site_address" name="site_address" placeholder="Enter Site Address" type="text" class="form-control">
                                        @error('site_address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_city">City</label>
                                        <input id="site_city" name="site_city" placeholder="Enter Site City" type="text" class="form-control">
                                        @error('site_city')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_country">Country</label>
                                        <input id="site_country" name="site_country" placeholder="Enter Site Country" type="text" class="form-control">
                                        @error('site_country')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_postal_code">Postal Code</label>
                                        <input id="site_postal_code" name="site_postal_code" placeholder="Enter Site Postal Code" type="text" class="form-control">
                                        @error('site_postal_code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_description">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea id="site_description" name="site_description" class="form-control"
                                            placeholder="Enter Site Description" rows="3"></textarea>
                                        @error('site_description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="site_logo">Logo <span class="text-danger">*</span></label>
                                <input type="file" id="site_logo" name="site_logo" class="form-control" />
                                @error('site_logo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="site_favicon">Favicon <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="site_favicon" name="site_favicon" class="form-control" />
                                @error('site_favicon')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_facebook">Facebook</label>
                                        <input id="site_facebook" name="site_facebook" placeholder="Enter Site Facebook URL" type="text" class="form-control">
                                        @error('site_facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_twitter">Twitter</label>
                                        <input id="site_twitter" name="site_twitter" placeholder="Enter Site Twitter URL" type="text" class="form-control">
                                        @error('site_twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_instagram">Instagram</label>
                                        <input id="site_instagram" name="site_instagram" placeholder="Enter Site Instagram URL" type="text" class="form-control">
                                        @error('site_instagram')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="site_linkedin">LinkedIn</label>
                                        <input id="site_linkedin" name="site_linkedin" placeholder="Enter Site LinkedIn URL" type="text" class="form-control">
                                        @error('site_linkedin')
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
    @section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection