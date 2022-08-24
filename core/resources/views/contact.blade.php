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
    <div class="section section-pad">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 res-m-bttm">
                    <div class="contact-information">
                        <h4>{{ $page_title }}</h4>
                        <div class="row">
                            <div class="col-sm-12 res-m-bttm">
                                Couldn't find answer to your question in FAQ? Contact us for support and questions.
                            </div>
                        </div>
                    </div>
                    <div class="contact-form">
                        <p>Complete and submit the form below</p>
                        <form class="form-message" action="{{ route('contact') }}" method="post">
                            @csrf
                            <div class="form-results"></div>
                            <div class="form-group row">
                                <div class="form-field col-sm-6 form-m-bttm">
                                    <input name="contact_name" type="text" placeholder="Full Name *"
                                        class="form-control required" required>
                                </div>
                                <div class="form-field col-sm-6">
                                    <input name="contact_email" type="email" placeholder="Email *"
                                        class="form-control required email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-field col-sm-12">
                                    <input name="contact_subject" type="text" placeholder="Subject *"
                                        class="form-control required" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-field col-md-12">
                                    <textarea name="contact_message" placeholder="Messages *" class="txtarea form-control required" required></textarea>
                                </div>
                            </div>
                            {{--  <input type="text" class="hidden" name="form-anti-honeypot" value="">  --}}
                            <button type="submit" class="btn btn-alt">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <!-- .col  -->
            </div>
        </div>
    </div>
    <!-- End Section -->
@endsection
