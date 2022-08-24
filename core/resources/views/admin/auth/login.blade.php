@extends('admin.layouts.auth')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Authentication card start -->

            <form method="POST" action="{{ route('admin.login') }}" class="md-float-material form-material">
                @csrf
                <div class="text-center">
                    <img src="{{ asset('assets/images/logo.png') }}"
                    alt="{{ $settings->sitename() }}">
                </div>
                <div class="auth-box card">
                    <div class="card-block">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center">Sign In</h3>
                            </div>
                        </div>
                        <div class="form-group form-primary">
                            <input type="email" name="email" class="form-control" required=""
                                placeholder="Your Email Address" value="{{ old('email') }}" autocomplete="email" autofocus>
                            <span class="form-bar"></span>
                        </div>
                        <div class="form-group form-primary">
                            <input type="password" name="password" class="form-control" required=""
                                placeholder="Password" autocomplete="current-password">
                            <span class="form-bar"></span>
                        </div>
                        <div class="row m-t-25 text-left">
                            <div class="col-12">
                                <div class="checkbox-fade fade-in-primary d-">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="cr"><i
                                                class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                        <span class="text-inverse">Remember me</span>
                                    </label>
                                </div>
                                <div class="forgot-phone text-right f-right">
                                    <a href="{{ route('admin.password.request') }}" class="text-right f-w-600"> Forgot
                                        Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <button type="submit"
                                    class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign
                                    in</button>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-10">
                                <p class="text-inverse text-left m-b-0">Thank you.</p>
                                <p class="text-inverse text-left"><a href="{{ route('home') }}"><b class="f-w-600">Back
                                            to website</b></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- end of form -->
        </div>
        <!-- end of col-sm-12 -->
    </div>
    <!-- end of row -->
@endsection
