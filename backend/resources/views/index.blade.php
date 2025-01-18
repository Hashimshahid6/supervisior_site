@extends('layouts.master')
@section('title')
Dashboard
@endsection
@section('page-title')
Dashboard
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    @php
    $payment = auth()->user()->payment()->latest()->first();
    $startDate = \Carbon\Carbon::parse(@$payment->start_date);
    $endDate = \Carbon\Carbon::parse(@$payment->end_date);
    $currentDate = \Carbon\Carbon::now();
    $totalDays = $startDate->diffInDays($endDate);
    $daysLeft = $currentDate->diffInDays($endDate, false); // false to get negative values if expired
    $daysLeft = floor($daysLeft); // Round down to the nearest whole number
    @endphp
    @if(auth()->user()->role == 'Company')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-message-alert me-2"></i>
        Your free trial will end in <strong>{{ $daysLeft > 0 ? $daysLeft : 0 }}</strong> days.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row mt-2">
        @if(auth()->user()->role == 'Company')
        <div class="col-md-6 col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="font-size-15">Employees</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$employees->count()}} <span
                                    class="text-danger fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-user font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 font-size-15">Projects</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$projects->count()}} <span
                                    class="text-danger fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-folder font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 font-size-15">Active Package</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$activePackage->name}} <span
                                    class="text-success fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-package font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-6 col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="font-size-15">Sales</h6>
                            <h4 class="mt-3 pt-1 mb-0 font-size-22">{{$sales}} <span
                                    class="text-success fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-pound font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 font-size-15">Projects</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$projects->count()}} <span
                                    class="text-danger fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-folder font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 font-size-15">Companies</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$companies->count()}} <span
                                    class="text-success fw-medium font-size-14 align-middle"></h4>
                        </div>
                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-buildings font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 font-size-15">Employees</h6>
                            <h4 class="mt-3 mb-0 font-size-22">{{$employees->count()}} <span
                                    class="text-danger fw-medium font-size-14 align-middle"></h4>
                        </div>

                        <div class="">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary-subtle">
                                    <i class="bx bx-user font-size-24 mb-0 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- END ROW -->

    @if(auth()->user()->role == 'Admin')
    <!-- Subscription Graph -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Subscriptions Overview</h5>
                    <div id="subscriptions-chart"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- end row -->

    @endsection
    @section('scripts')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [
                @foreach($subscriptions->groupBy('package_name') as $packageName => $data)
                {
                    name: '{{ $packageName }}',
                    data: [
                        @foreach($data as $subscription)
                        {
                            x: '{{ DateTime::createFromFormat('!m', $subscription->month)->format('M') }}',
                            y: {{ $subscription->total_sales }},
                            count: {{ $subscription->count }},
                            amount: {{ $subscription->total_sales }}
                        },
                        @endforeach
                    ]
                },
                @endforeach
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: 'Total Sales'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val, { series, seriesIndex, dataPointIndex, w }) {
                        var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                        return 'Package: ' + w.globals.seriesNames[seriesIndex] + '<br>' +
                            'Total Amount: £' + data.amount + '<br>' +
                            'Sales Count: ' + data.count;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#subscriptions-chart"), options);
        chart.render();
    });
    </script>
    @endsection