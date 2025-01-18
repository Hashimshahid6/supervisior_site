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
@include('components.flash_messages')
<!-- search filters -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <a href="{{route('users.create')}}" class="btn btn-primary"><i class="bx bx-plus me-1"></i>
                        Add New</a>
                </div>
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="package_id" class="form-label">Package</label>
                                <select class="form-select" id="package_id" name="package_id">
                                    <option value="">Select Package</option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" @if(request()->package_id == $package->id)
                                        selected @endif>{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="">Select Role</option>
                                    <option value="Admin" @if(request()->role == 'Admin') selected @endif>Admin
                                    </option>
                                    <option value="Company" @if(request()->role == 'Company') selected
                                        @endif>Company</option>
                                    <option value="Employee" @if(request()->role == 'Employee') selected
                                        @endif>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Select Status</option>
                                    <option value="Active" @if(request()->status == 'Active') selected @endif>Active
                                    </option>
                                    <option value="Inactive" @if(request()->status == 'Inactive') selected
                                        @endif>Inactive</option>
                                    <option value="Deleted" @if(request()->status == 'Deleted') selected
                                        @endif>Deleted</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="sort_by" class="form-label">Sort By</label>
                                <select class="form-select" id="sort_by" name="sort_by">
                                    <option value="id" @if(request()->sort_by == 'id') selected @endif>ID</option>
                                    <option value="name" @if(request()->sort_by == 'name') selected @endif>Name
                                    </option>
                                    <option value="email" @if(request()->sort_by == 'email') selected @endif>Email
                                    </option>
                                    <option value="role" @if(request()->sort_by == 'role') selected @endif>Role
                                    </option>
                                    <option value="status" @if(request()->sort_by == 'status') selected
                                        @endif>Status</option>
                                    <option value="phone" @if(request()->sort_by == 'phone') selected @endif>Phone
                                    </option>
                                    <option value="created_at" @if(request()->sort_by == 'created_at') selected
                                        @endif>Created At</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <select class="form-select" id="sort_order" name="sort_order">
                                    <option value="desc" @if(request()->sort_order == 'desc') selected
                                        @endif>Descending</option>
                                    <option value="asc" @if(request()->sort_order == 'asc') selected
                                        @endif>Ascending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="per_page" class="form-label">Per Page</label>
                                <select class="form-select" id="per_page" name="per_page">
                                    <option value="10" @if(request()->per_page == '10') selected @endif>10</option>
                                    <option value="25" @if(request()->per_page == '25') selected @endif>25</option>
                                    <option value="50" @if(request()->per_page == '50') selected @endif>50</option>
                                    <option value="100" @if(request()->per_page == '100') selected @endif>100
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('users.index') }}" class="btn btn-danger">Reset</a>
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
                                <th scope="col">Package</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start text-start">
                                        <!-- User Image -->
                                        <div class="me-3">
                                            <img src="{{ URL::asset('public/uploads/users/' . $user->avatar) }}"
                                                alt="{{ $user->name }}" class="avatar-sm rounded-circle">
                                        </div>
                                        <!-- Title and Description -->
                                        <div>
                                            <h6 class="mb-1">{{ $user->name }}</h6>
                                            <p class="font-bold mb-0">{{ $user->email }}</p>
                                            <p class="text-semibold mb-0">{{ $user->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->package)
                                    @if($user->package->id == 1)
                                    <span class="badge bg-primary-subtle text-primary mb-0">{{ $user->package->name
                                        }}</span>
                                    @elseif($user->package->id == 2)
                                    <span class="badge bg-success-subtle text-success mb-0">{{ $user->package->name
                                        }}</span>
                                    @elseif($user->package->id == 3)
                                    <span class="badge bg-danger-subtle text-danger mb-0">{{ $user->package->name
                                        }}</span>
                                    @endif
                                    @else
                                    <span class="badge bg-danger text-white">No Package</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role == 'Admin')
                                    <span class="badge bg-success-subtle text-success mb-0">Admin</span>
                                    @elseif($user->role == 'Company')
                                    <span class="badge bg-primary-subtle text-primary mb-0">Company</span>
                                    @elseif($user->role == 'Employee')
                                    <span class="badge bg-danger-subtle text-danger mb-0">Employee</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary  mb-0">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span></td>
                                <td>
                                    @if($user->status == 'Active')
                                    <span class="badge bg-success-subtle text-dark mb-0">Active</span>
                                    @elseif($user->status == 'Inactive')
                                    <span class="badge bg-warning-subtle text-warning mb-0">Inactive</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger mb-0">Deleted</span>
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@endsection