@extends('layouts.master')
@section('title')
Profile Info
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Profile Info
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    @include('components.flash_messages')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('public/uploads/users/' . $user->avatar) }}" alt="User Image" class="rounded-circle" width="150">
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="auto_renewal" value="No">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}" required>
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                    @error('avatar')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <span class="text-muted">Leave blank if you don't want to change password</span>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if($user->role == 'Company')
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="package" class="form-label">Package</label>
                                    <input type="text" class="form-control" id="package" name="package" value="{{ $user->package->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="auto_renewal" class="form-label">Auto Renewal</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                            id="auto_renewal" name="auto_renewal" value="Yes" {{ $user->auto_renewal == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_renewal"></label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-success"> <i class="bx bx-check me-1"></i>
                                        Save Changes </button>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection