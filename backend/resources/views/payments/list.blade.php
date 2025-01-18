@extends('layouts.master')
@section('title')
Transactions
@endsection
@section('page-title')
Transactions
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <!-- search filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('transactions.index') }}" method="GET">
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
                                    <label for="status" class="form-label">Payment Status</label>
                                    <select class="form-select" name="payment_status">
                                        <option value="">Select Status</option>
                                        <option value="Completed" @if(request()->payment_status == 'Completed') selected @endif>Paid
                                        </option>
                                        <option value="Pending" @if(request()->payment_status == 'Pending') selected
                                            @endif>Pending</option>
                                        <option value="Cancelled" @if(request()->payment_status == 'Cancelled') selected
                                            @endif>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ request()->start_date }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ request()->end_date }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="sort_by" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort_by" name="sort_by">
                                        <option value="id" @if(request()->sort_by == 'id') selected @endif>ID</option>
                                        <option value="amount" @if(request()->sort_by == 'amount') selected
                                            @endif>Amount</option>
                                        <option value="payment_status" @if(request()->sort_by == 'payment_status') selected
                                            @endif>Payment Status</option>
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
                                    <a href="{{ route('transactions.index') }}" class="btn btn-danger">Reset</a>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Days to Expiry</th>
                                    <th scope="col">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ @$payment->user->name }}</span>
                                            <span>{{ @$payment->user->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($payment->package_id == 1)
                                        <span class="badge bg-primary-subtle text-primary mb-0">{{
                                            $payment->package->name }}</span>
                                        @elseif($payment->package_id == 2)
                                        <span class="badge bg-success-subtle text-success mb-0">{{
                                            $payment->package->name }}</span>
                                        @elseif($payment->package_id == 3)
                                        <span class="badge bg-danger-subtle text-danger">{{ $payment->package->name
                                            }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-dark">
                                            <i class="bx bx-pound"></i>{{ $payment->amount }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($payment->payment_status == 'Completed')
                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                        @elseif($payment->payment_status == 'Pending')
                                        <span class="badge bg-primary-subtle text-primary">Pending</span>
                                        @elseif($payment->payment_status == 'Cancelled')
                                        <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ \Carbon\Carbon::parse($payment->start_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ \Carbon\Carbon::parse($payment->end_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger">
                                            @php
                                            $startDate = \Carbon\Carbon::parse(@$payment->start_date);
                                            $endDate = \Carbon\Carbon::parse(@$payment->end_date);
                                            $currentDate = \Carbon\Carbon::now();
                                            $totalDays = $startDate->diffInDays($endDate);
                                            $daysLeft = $currentDate->diffInDays($endDate, false); // false to get
                                            $daysLeft = floor($daysLeft); // Round down to the nearest whole number
                                            @endphp
                                            {{ $daysLeft > 0 ? $daysLeft : 0 }} days left
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $payment->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection