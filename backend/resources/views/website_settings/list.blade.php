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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Favicon</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Postal Code</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Facebook</th>
                                    <th scope="col">Twitter</th>
                                    <th scope="col">Instagram</th>
                                    <th scope="col">Linkedin</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($websiteSettings as $setting)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ URL::asset('images/settings/' . $setting->logo) }}" target="_blank">
                                            <i class="bx bx-image" style="font-size: 24px;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::asset('images/settings/' . $setting->favicon) }}" target="_blank">
                                            <i class="bx bx-image" style="font-size: 24px;"></i>
                                        </a>
                                    </td>
                                    <td>{{ $setting->site_name }}</td>
                                    <td>{{ $setting->site_email }}</td>
                                    <td>{{ $setting->site_phone }}</td>
                                    <td>{{ $setting->site_city }}</td>
                                    <td>{{ $setting->site_country }}</td>
                                    <td>{{ $setting->site_postal_code }}</td>
                                    <td>{{ $setting->site_address }}</td>
                                    <td>{{ $setting->site_description }}</td>
                                    <td>{{ $setting->site_facebook }}</td>
                                    <td>{{ $setting->site_twitter }}</td>
                                    <td>{{ $setting->site_instagram }}</td>
                                    <td>{{ $setting->site_linkedin }}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('website_settings.edit', $setting->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete" class="px-2 text-danger"
                                                    onclick="deleteWebsiteSetting({{ $setting->id }})"><i
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