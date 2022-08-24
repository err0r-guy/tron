<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $settings->sitename(__($page_title)) }} </title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ $settings->description }}">
    <meta name="keywords" content="{{ implode(',', explode(',', $settings->keywords)) }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/assets/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/icofont/css/icofont.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
</head>

<body>
    {{-- @include('admin.partials.preloader') --}}

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            @yield('content')
        </div>
        <!-- end of container-fluid -->
    </section>

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/jquery-slimscroll/jquery.slimscroll.js') }}">
    </script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('admin/assets/vendor/modernizr/modernizr.js') }}"></script>
    <!-- custom js -->
    
    <script type="text/javascript" src="{{ asset('admin/assets/js/common-pages.js') }}"></script>
</body>

</html>
