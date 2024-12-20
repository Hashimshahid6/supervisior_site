@extends('layouts.master')
@section('title')
Edit Package
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Edit Package
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Package Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $package->name }}" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ $package->price }}" required>
                            @error('price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $package->description }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="trial_text" class="form-label">Trial Text</label>
                            <input type="text" class="form-control" id="trial_text" name="trial_text" value="{{ $package->trial_text }}" required>
                            @error('trial_text')
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
    @endsection
    @section('scripts')
    <!-- Add any additional JS if needed -->
    @endsection