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
                <h5 class="card-title">Employees List <span class="text-muted fw-normal ms-2">( {{ $users->count()}}
                        )</span></h5>
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
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection