@extends('layouts.master')
@section('title')
Website Settings
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Website Settings
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    {{-- <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Website Settings List <span class="text-muted fw-normal ms-2"></h5>
            </div>
        </div>

        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('website_settings.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
                        Add New</a>
                </div>
            </div>

        </div>
    </div> --}}
    @include('components.flash_messages')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Logo/Favicon</th>
                                    <th scope="col">Name & Email</th>
                                    <th scope="col">Phone(s)</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Social Links</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($websiteSettings as $setting)
                                <tr>
                                    <td>
                                        <a href="{{ URL::asset('public/images/websiteimages/' . $setting->site_logo) }}" target="_blank">
                                            <img src="{{ URL::asset('public/images/websiteimages/' . $setting->site_logo) }}" alt="Logo" 
                                            height="50" width="50" class="img-fluid rounded">
                                        </a>
                                        </a>
                                        /
                                        <a href="{{ URL::asset('public/images/websiteimages/' . $setting->site_favicon) }}" target="_blank">
                                            <img src="{{ URL::asset('public/images/websiteimages/' . $setting->site_favicon) }}" alt="Favicon" 
                                            height="50" width="50" class="img-fluid rounded">
                                        </a>
                                    </td>
                                    <td>
                                        <strong>{{ $setting->site_name }}</strong><br>
                                        {{ $setting->site_email }}<br>
                                        {{ $setting->site_email2 }}
                                    </td>
                                    <td>
                                        {{ $setting->site_phone }}<br>
                                        {{ $setting->site_phone2 }}
                                    </td>
                                    <td>
                                        <strong>{{ $setting->site_city }}, {{ $setting->site_country }}</strong><br>
                                        {{ $setting->site_address }}, ({{ $setting->site_postal_code }})
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($setting->site_description, 50, '...') }}</td>
                                    <td>
                                        <a href="{{ $setting->site_facebook }}" target="_blank" class="text-primary me-2"><i class="bx bxl-facebook-circle"></i></a>
                                        <a href="{{ $setting->site_twitter }}" target="_blank" class="text-info me-2"><i class="bx bxl-twitter"></i></a>
                                        <a href="{{ $setting->site_instagram }}" target="_blank" class="text-danger me-2"><i class="bx bxl-instagram"></i></a>
                                        <a href="{{ $setting->site_linkedin }}" target="_blank" class="text-primary"><i class="bx bxl-linkedin"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('website_settings.edit', $setting->id) }}" class="text-primary me-2" title="Edit">
                                            <i class="bx bx-pencil font-size-18"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-danger" title="Delete" onclick="deleteWebsiteSetting({{ $setting->id }})">
                                            <i class="bx bx-trash-alt font-size-18"></i>
                                        </a>
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