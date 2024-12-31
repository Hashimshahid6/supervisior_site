@extends('layouts.master-without-nav')
@section('title')
    Register
@endsection
@section('page-title')
    Register
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="authentication-bg min-vh-100">
            <div class="bg-overlay bg-light"></div>
            <div class="container">
                <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            @php
                            $settings = \App\Models\WebsiteSettings::first();
                            @endphp
                            <div class="mb-4 d-flex justify-content-center align-items-center">
                                <div>
                                    <a href="index" class="d-block auth-logo">
                                        <img src="{{ URL::asset('public/images/websiteimages/'. $settings->site_logo) }}" alt="{{ $settings->site_name }}"
                                            height="50" width="50" style="border-radius: 50%">
                                    </a>
                                </div>
                                <div class="ms-3">
                                    <!-- Added margin class here -->
                                    <h4 style="font-size:30px; font-weight:bold">{{ $settings->site_name }}</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5>Register Account</h5>
                                        <p class="text-muted">Get access to members area.</p>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form method="POST" action="{{ route('register.post') }}" class="auth-input">
                                            @csrf
                                            <div class="mb-2">
                                                <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                                    placeholder="Enter name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-2">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email"
                                                    placeholder="Enter email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-2">
                                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                <input id="phone" type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone') }}" required autocomplete="phone"
                                                    placeholder="Enter phone">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required id="password-input"
                                                    placeholder="Enter password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-confirm">Confirm
                                                    Password <span class="text-danger">*</span></label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password_confirmation" required id="password-confirm"
                                                    placeholder="Enter confirm password">
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Register</button>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                                                        class="fw-medium text-primary"> Login</a></p>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center p-4">
                                <p>
                                    &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    supervisesite.co.uk, All Rights Reserved.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- end container -->
        </div>
        <!-- end authentication section -->
    @endsection