@extends('layouts.master')
@section('title')
Edit Website Settings
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Edit Website Settings
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('website_settings.update', $websiteSettings->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_name">Site Name <span
                                            class="text-danger">*</span></label>
                                    <input id="site_name" name="site_name" placeholder="Enter Site Name" type="text"
                                        class="form-control" value="{{ $websiteSettings->site_name }}">
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
                                        class="form-control" value="{{ $websiteSettings->site_url }}">
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
                                    <input id="site_email" name="site_email" placeholder="Enter Site Email" type="email" class="form-control" value="{{ $websiteSettings->site_email }}">
                                    @error('site_email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_email2">Email 2</label>
                                    <input id="site_email2" name="site_email2" placeholder="Enter Site Email 2" type="email" class="form-control" value="{{ $websiteSettings->site_email2 }}">
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
                                    <input id="site_phone" name="site_phone" placeholder="Enter Site Phone" type="text" class="form-control" value="{{ $websiteSettings->site_phone }}">
                                    @error('site_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_phone2">Phone 2</label>
                                    <input id="site_phone2" name="site_phone2" placeholder="Enter Site Phone 2" type="text" class="form-control" value="{{ $websiteSettings->site_phone2 }}">
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
                                    <input id="site_address" name="site_address" placeholder="Enter Site Address" type="text" class="form-control" value="{{ $websiteSettings->site_address }}">
                                    @error('site_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_city">City</label>
                                    <input id="site_city" name="site_city" placeholder="Enter Site City" type="text" class="form-control" value="{{ $websiteSettings->site_city }}">
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
                                    <input id="site_country" name="site_country" placeholder="Enter Site Country" type="text" class="form-control" value="{{ $websiteSettings->site_country }}">
                                    @error('site_country')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_postal_code">Postal Code</label>
                                    <input id="site_postal_code" name="site_postal_code" placeholder="Enter Site Postal Code" type="text" class="form-control" value="{{ $websiteSettings->site_postal_code }}">
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
                                    <textarea id="site_description" name="site_description" placeholder="Enter Site Description" class="form-control" rows="4">{{ $websiteSettings->site_description }}</textarea>
                                    @error('site_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="site_logo">Logo <span class="text-danger">*</span></label>
                            <input type="file" id="site_logo" name="site_logo" class="form-control" />
                            <img src="{{ URL::asset('public/images/websiteimages/' . $websiteSettings->site_logo) }}" alt="Logo" class="img-fluid" style="width: 100px; height: 100px;">
                            @error('site_logo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="site_favicon">Favicon <span
                                    class="text-danger">*</span></label>
                            <input type="file" id="site_favicon" name="site_favicon" class="form-control" />
                            <img src="{{ URL::asset('public/images/websiteimages/' . $websiteSettings->site_favicon) }}" alt="Favicon" class="img-fluid" style="width: 100px; height: 100px;">
                            @error('site_favicon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_facebook">Facebook</label>
                                    <input id="site_facebook" name="site_facebook" placeholder="Enter Site Facebook URL" type="text" class="form-control" value="{{ $websiteSettings->site_facebook }}">
                                    @error('site_facebook')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_twitter">Twitter</label>
                                    <input id="site_twitter" name="site_twitter" placeholder="Enter Site Twitter URL" type="text" class="form-control" value="{{ $websiteSettings->site_twitter }}">
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
                                    <input id="site_instagram" name="site_instagram" placeholder="Enter Site Instagram URL" type="text" class="form-control" value="{{ $websiteSettings->site_instagram }}">
                                    @error('site_instagram')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="site_linkedin">LinkedIn</label>
                                    <input id="site_linkedin" name="site_linkedin" placeholder="Enter Site LinkedIn URL" type="text" class="form-control" value="{{ $websiteSettings->site_linkedin }}">
                                    @error('site_linkedin')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    @endsection
    @section('scripts')
    <!-- Add any additional JS if needed -->
    @endsection