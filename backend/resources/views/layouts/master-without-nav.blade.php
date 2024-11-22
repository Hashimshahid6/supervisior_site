<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Supervisesite - Members Area</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Supervise Site, based in Rye, East Sussex, is dedicated to providing cutting-edge solutions for construction project management." name="description" />
    <meta content="Supervise Site" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.head-css')
</head>

<body>
    
    @yield('content')

    <!-- vendor-scripts -->
    @include('layouts.vendor-scripts')

</body>

</html>
