@extends('layouts.app')

@section('banner')
<!-- Banner/Slider -->
<div id="header" class="banner banner-md light row-vm">
    <div class="imagebg imagebg-bottom">
        <img src="assets/images/header-bg-d.jpg" alt="bg">
    </div>
    <div class="container">
        <div class="banner-content">
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h1  id="signup">Automated {{ settings('currency') }} mining process!</h1>
                </div>
                <div class="gaps size-1x"></div>
            </div>
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3">
                    <p class="lead">Enter your {{ settings('currency') }} Wallet Address to Sign Up / Sign In</p>
                    <div class="btns">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            @if (session()->get('reference') != null)
                            <input type="hidden" name="referBy" value="{{ session()->get('reference') }}"
                                        readonly>
                                @endif
                                <div style="margin-bottom: 20px !important;">
                                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                                        minlength="{{ $settings->wallet_min }}" maxlength="{{ $settings->wallet_max }}"
                                        class="form-control @error('username') error @enderror"
                                        placeholder="Enter Your {{ settings('currency') }} Wallet Address" required>
                                    @error('username')
                                        <span style="color:#FF4346" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div style="margin-bottom: 20px !important;">
                                    <input type="password" name="password" id="password"
                                    class="form-control @error('password') error @enderror" placeholder="Password"
                                        required>
                                    @error('password')
                                        <span style="color:#FF4346" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-outline btn-alt btn-md">Start Mining</button>
                                <div><strong><a href="#" class="forgetPassword" data-toggle="modal"
                                            data-target="#forgetPassword">Forget Password?</a></strong></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner/Slider -->
@endsection

@section('content')
    <!--Section -->
    <div class="section section-pad bg-grey">
        <div class="container">
            <div class="row row-vm">
                <div class="col-md-5">
                    <div class="round mgr--30 res-m-bttm"><img src="assets/images/photo-md-a.jpg" alt="photo-md"
                            class="img-shadow">
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-1 ">
                        <div class="text-block">
                            {{ session()->get('reference') }}
                            <h2>Trxminer is an innovative &amp; a new kind of money.</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                        {{-- <a href="#" class="btn btn-alt">Read More</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Section -->

    <!-- Section -->
    <div class="section section-pad-sm cta-small light">
        <div class="cta-block">
            <div class="container">
                <div class="row mobile-center">
                    <div class="col-md-12">
                        <div class="cta-sameline">
                            <h3>Start mining now!</h3>
                            <a class="btn btn-outline btn-alt btn-md" href="#">get started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section -->

    <!-- Modal -->
    <div class="modal fade" id="forgetPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forget Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-12">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                            <div class="col-md-7">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <small class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary ud-btn">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    @include('partials.plans')
@endsection
