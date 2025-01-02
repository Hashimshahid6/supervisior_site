@extends('layouts.master')
@section('title')
Employees
@endsection
@section('css')
<!-- swiper css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

<!-- nouisliderribute css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">
@endsection
@section('page-title')
Employees
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Employees List <span class="text-muted fw-normal ms-2">( {{ $users->total() }} )</span></h5>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('users.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
                        Add New</a>
                </div>
            </div>
        </div>
    </div>
    @include('components.flash_messages')
    <!-- search filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.index') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ request()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ request()->email }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="">Select Role</option>
                                        <option value="Admin" @if(request()->role == 'Admin') selected @endif>Admin</option>
                                        <option value="Company" @if(request()->role == 'Company') selected @endif>Company</option>
                                        <option value="Employee" @if(request()->role == 'Employee') selected @endif>Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="Active" @if(request()->status == 'Active') selected @endif>Active</option>
                                        <option value="Inactive" @if(request()->status == 'Inactive') selected @endif>Inactive</option>
                                        <option value="Deleted" @if(request()->status == 'Deleted') selected @endif>Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ request()->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="per_page" class="form-label">Per Page</label>
                                    <select class="form-select" id="per_page" name="per_page">
                                        <option value="10" @if(request()->per_page == '10') selected @endif>10</option>
                                        <option value="25" @if(request()->per_page == '25') selected @endif>25</option>
                                        <option value="50" @if(request()->per_page == '50') selected @endif>50</option>
                                        <option value="100" @if(request()->per_page == '100') selected @endif>100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="sort_by" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort_by" name="sort_by">
                                        <option value="id" @if(request()->sort_by == 'id') selected @endif>ID</option>
                                        <option value="name" @if(request()->sort_by == 'name') selected @endif>Name</option>
                                        <option value="email" @if(request()->sort_by == 'email') selected @endif>Email</option>
                                        <option value="role" @if(request()->sort_by == 'role') selected @endif>Role</option>
                                        <option value="status" @if(request()->sort_by == 'status') selected @endif>Status</option>
                                        <option value="phone" @if(request()->sort_by == 'phone') selected @endif>Phone</option>
                                        <option value="created_at" @if(request()->sort_by == 'created_at') selected @endif>Created At</option>
                                        <option value="updated_at" @if(request()->sort_by == 'updated_at') selected @endif>Updated At</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <select class="form-select" id="sort_order" name="sort_order">
                                        <option value="asc" @if(request()->sort_order == 'asc') selected @endif>Ascending</option>
                                        <option value="desc" @if(request()->sort_order == 'desc') selected @endif>Descending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request()->search }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3 mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start text-start">
                                            <!-- Title and Description -->
                                            <div>
                                                <h6 class="mb-1">{{ $user->name }}</h6>
                                                <p class="font-bold mb-0">{{ $user->email }}</p>
                                                <p class="text-semibold mb-0">{{ $user->phone }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->role == 'Admin')
                                        <span class="badge bg-success text-white">Admin</span>
                                        @elseif($user->role == 'Company')
                                        <span class="badge bg-primary text-white">Company</span>
                                        @elseif($user->role == 'Employee')
                                        <span class="badge bg-success text-white">Employee</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 'Active')
                                        <span class="badge bg-success text-white">Active</span>
                                        @elseif($user->status == 'Inactive')
                                        <span class="badge bg-warning text-white">Inactive</span>
                                        @else
                                        <span class="badge bg-danger text-dark">Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                        class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection