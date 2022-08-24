<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="brainiachades">
    <meta name="email" content="brainiachades@gmail.com">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- seo --}}
    @include('partials.seo')
    <!-- Vendor Bundle CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" id="layoutstyle" href="{{ asset('assets/css/theme-blue.css') }}">
    <!-- Alert css -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .btn.ud-btn:hover,
        .btn.ud2-btn {
            color: #145DCC;
        }

        .btn.ud2-btn:hover {
            color: #ffffff;
        }
    </style>
    @section('addCss')
    @show
</head>

<body>
    <!-- Header -->
    <header class="site-header header-s1 is-sticky">
        <!-- Navbar -->
        <div class="navbar navbar-primary">
            <div class="container relative">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo logo-dark" alt="{{ $settings->sitename() }}"
                        src="{{ asset('assets/images/logo.png') }}">
                    <img class="logo logo-light" alt="{{ $settings->sitename() }}"
                        src="{{ asset('assets/images/logo_white.png') }}">
                </a>
                <!-- #end Logo -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnav"
                        aria-expanded="false">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- <div class="quote-btn"><a class="btn" href="{{ route('home') }}"><span>get started</span></a></div> -->
                </div>
                <!-- MainNav -->
                <nav class="navbar-collapse collapse" id="mainnav">
                    <ul class="nav navbar-nav">
                        @if (!empty(settings('telegram')))
                            <li><a href="{{ settings('telegram') }}" <button><i class="fa fa-telegram" style="font-size:20px"></i>Join our Telegram</button>
                        @endif
                        @guest
                            <li><a href="{{ route('home') }}">Home</a></li>
                        @else
                            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle">Account <b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user.transactions') }}">Transactions</a></li>
                                    <li><a href="{{ route('user.profile') }}">Profile</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                        <li><a href="{{ route('affiliate') }}">Affilite Program</a></li>
                        <li><a href="{{ route('payouts') }}">Payouts</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </nav>
                <!-- #end MainNav -->
            </div>
        </div>
        <!-- End Navbar -->

        @yield('banner')
    </header>
    <!-- End Header -->

    {{-- main --}}
    @yield('content')
    {{-- end main --}}

    <!-- Section Footer -->
    <div class="footer-section section section-pad-md light bg-footer">
        <div class="imagebg footerbg">
            <img src="{{ asset('assets/images/footer-bg.png') }}" alt="footer-bg">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 wgs-box res-m-bttm">
                    <!-- Each Widget -->
                    <div class="wgs-footer wgs-menu">
                        <h5 class="wgs-title ucap">Links</h5>
                        <div class="wgs-content">
                            <ul class="menu">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('affiliate') }}">Affilite Program</a></li>
                                <li><a href="{{ route('payouts') }}">Payouts</a></li>
                                <li><a href="{{ route('faq') }}">FAQ</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>
                <div class="col-md-6 col-sm-6 wgs-box res-m-bttm">
                    <!-- Each Widget -->
                    <div class="wgs-footer wgs-contact">
                        <h5 class="wgs-title ucap">get in touch</h5>
                        <div class="wgs-content">
                            <ul class="wgs-contact-list">
                                <li><span class="pe pe-7s-map-marker"></span>217 Summit Boulevard <br />Birmingham, AL
                                    35243</li>
                                <li><span class="pe pe-7s-call"></span>Telephone : (123) 4567 8910 <br />Telephone :
                                    (123) 1234 5678
                                </li>
                                <li><span class="pe pe-7s-global"></span>Email : <a
                                        href="mailto:info@sitename.com">info@sitename.com</a> <br />Web : <a
                                        href="{{ config('app.url') }}">{{ config('app.url') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Section -->

    <!-- Copyright -->
    <div class="copyright light">
        <div class="container">
            <div class="row">
                <div class="site-copy col-sm-12 text-center">
                    <p>Copyright &copy; 2022 {{ $settings->sitename() }}. Template Made by <a
                            href="#">Brainiachades</a></p>
                </div>
                <!-- <div class="col-sm-5 text-right mobile-left">
          <ul class="social">
            <li><a href="#"><em class="fa fa-facebook"></em></a></li>
            <li><a href="#"><em class="fa fa-twitter"></em></a></li>
            <li><a href="#"><em class="fa fa-linkedin"></em></a></li>
            <li><a href="#"><em class="fa fa-google-plus"></em></a></li>
          </ul>
        </div> -->
            </div>
        </div>
    </div>
    <!-- End Copyright -->




    <!-- Preloader !remove please if you do not want -->
    {{-- <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> --}}
    <!-- Preloader End -->

    <!-- JavaScript ======= -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="{{ asset('assets/js/jquery.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @section('addJs')
    @show
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
        @if (Session::has('status'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('status') }}");
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
