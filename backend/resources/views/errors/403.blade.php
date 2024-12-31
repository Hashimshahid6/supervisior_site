@extends('layouts.master-without-nav')
@section('title')
    Forbidden 403
@endsection
@section('page-title')
    Forbidden 403
@endsection
@section('body')

    <body>
    @endsection
    @section('content')

    <div class="min-vh-100" style="background: url(build/images/bg-2.png) top;">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center py-5 mt-5">
                       <div class="position-relative">
                          <h1 class="error-title error-text mb-0">403</h1>
                          <h4 class="error-subtitle text-uppercase mb-0">Forbidden</h4>
                          <p class="font-size-16 mx-auto text-muted w-50 mt-4">You don't have permission to access this resource.</p>
                       </div>
                        <div class="mt-4 text-center">
                            <a class="btn btn-primary" href="{{route('projects.index')}}">Back to Projects</a>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end authentication section -->

@endsection