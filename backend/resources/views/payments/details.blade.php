@extends('layouts.master')
@section('title')
    Invoice Detail
@endsection
@section('page-title')
    Invoice Detail
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">Invoice #SVS-{{$invoice->id}} <span
                                    class="badge bg-success font-size-12 ms-2">{{$invoice->payment_status}}</span></h4>
                            <div class="mb-4">
                                <img src="{{ URL::asset('public/images/websiteimages/'. $setting->site_logo) }}" alt="logo" height="50" width="50"/>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1"><i class="mdi mdi-account-outline me-1"></i> {{$setting->site_name}}</p>
                                <p class="mb-1"><i class="mdi mdi-map-marker-outline me-1"></i> {{$setting->site_address}}</p>
                                <p class="mb-1"><i class="mdi mdi-email-outline me-1"></i> {{$setting->site_email}}</p>
                                <p><i class="mdi mdi-phone-outline me-1"></i> {{$setting->site_email}}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2">{{$invoice->user->name}}</h5>
                                    <p class="mb-1">{{$invoice->user->email}}</p>
                                    <p>{{$invoice->user->phone}}</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p>{{\Carbon\Carbon::parse($invoice->created_at)->format('d M Y')}}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order No:</h5>
                                        <p>#{{$invoice->id}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold" style="width: 70px;">No.</th>
                                            <th class="fw-bold">Package Name</th>
                                            <th class="fw-bold">Price</th>
                                            <th class="fw-bold">Quantity</th>
                                            <th class="text-end fw-bold" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14">{{$invoice->package->name}}</h5>
                                                </div>
                                            </td>
                                            <td> <i class="mdi mdi-currency-gbp"></i>{{$invoice->amount}}</td>
                                            <td>1</td>
                                            <td class="text-end"> <i class="mdi mdi-currency-gbp"></i>{{$invoice->amount}}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">Total</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold"> <i class="mdi mdi-currency-gbp"></i>{{$invoice->amount}}</h4>
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->
                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                            class="fa fa-print"></i></a>
                                    {{-- <a href="#" class="btn btn-primary w-md">Send</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    @endsection
    @section('scripts')
    @endsection
