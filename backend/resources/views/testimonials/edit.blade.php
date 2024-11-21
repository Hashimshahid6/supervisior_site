@extends('layouts.master')
@section('title')
Edit Testimonial
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Edit Testimonial
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $testimonial->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="{{ $testimonial->designation }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $testimonial->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            <img src="{{ URL::asset('images/testimonials/' . $testimonial->avatar) }}" alt="Avatar" class="img-thumbnail mt-2" width="150">
                        </div>
                        <div class="mb-3">
                            <label for="bgImage" class="form-label">Background Image</label>
                            <input type="file" class="form-control" id="bgImage" name="bgImage">
                            <img src="{{ URL::asset('images/testimonials/' . $testimonial->bgImage) }}" alt="Background Image" class="img-thumbnail mt-2" width="150">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status_edit" name="status" required>
                                <option value="Active" {{ $testimonial->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $testimonial->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Deleted" {{ $testimonial->status == 'Deleted' ? 'selected' : '' }}>Deleted</option>
                            </select>
                        </div>
                        <div class="row mb-4">
                            <div class="col text-end">
                                <a href="#" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancel </a>
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