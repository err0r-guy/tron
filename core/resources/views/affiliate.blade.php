@extends('layouts.app')

@section('banner')
    <!-- Banner/Slider -->
    <div class="page-head section row-vm light">
        <div class="imagebg">
            <img src="{{ asset('assets/images/page-inside-bg.jpg') }}" alt="page-head">
        </div>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2>{{ $page_title }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- #end Banner/Slider -->
@endsection

@section('content')
    <!-- Section -->
    <div class="section section-pad bg-grey">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>{{ $page_title }}</h4>
                    <div class="gaps size-1x"></div>
                </div>
            </div>
            <div class="faq-one row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">Invite your friends and get {{ $settings->ref_commission }}%.</h5>
                        <p>You can invite your friends by sharing your referral link to them on social media platform.</p>
                    </div>
                    <div class="gaps size-x2"></div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <!-- End Section -->

    @include('partials.plans')
@endsection
