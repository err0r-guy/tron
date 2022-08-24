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
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/icon/feather/css/feather.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    @section('addCss')
    @show
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/jquery.mCustomScrollbar.css') }}">
    <!-- Alert css -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    {{-- @include('admin.partials.preloader') --}}

    <div id="pcoded" class="pcoded">
        <div class="pcoded-container navbar-wrapper">

            @include('admin.partials.navbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    @include('admin.partials.sidebar')

                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                        @yield('content')
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

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

    <script src="{{ asset('admin/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/js/SmoothScroll.js') }}"></script>
    @section('addJs')
    @show
    <script src="{{ asset('admin/assets/js/pcoded.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('admin/assets/js/vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/js/script.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // deleting
            $('.delBtn').on('click', function(e) {
                var $delTitle = $(this).attr('data-delTitle');
                $('.delTitle').html($delTitle);
            });
            $('#delModal').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                $('#deleteForm').attr('action', button.attr('data-delAction'));
            });
        });
    </script>
    <!-- alert js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
</body>

</html>
