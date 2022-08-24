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
                <div class="col-md-12">
                    <h4>Frequently Asked <span>Questions</span></h4>
                    <div class="gaps size-1x"></div>
                </div>
            </div>
            <div class="faq-one row">
                <div class="col-md-6">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">How to get a bitCoin wallet ?</h5>
                        <p>Pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.
                            What's
                            happened to me he thought. It wasn't a dream. His room, a proper human room although.</p>
                    </div>
                    <div class="gaps size-x2"></div>
                </div>
                <div class="col-md-6">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">Why should any one use bitcoin ?</h5>
                        <p>Arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off
                            any
                            moment. His many legs, pitifully thin compared with the size of the rest of him waved.</p>
                    </div>
                    <div class="gaps size-x2"></div>
                </div>
                <div class="col-md-6">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">Can we use bitcoin wallet for free ?</h5>
                        <p>Consectetur adipisicing elit. Cupiditate, adipisci magni in explicabo facilis deleniti vel
                            perspiciatis
                            fugiat nam odit blanditiis corporis ad reiciendis ratione voluptatem ullam sunt consectetur
                            commodi.</p>
                    </div>
                    <div class="gaps size-x2"></div>
                </div>
                <div class="col-md-6">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">How could any one make a support request ?</h5>
                        <p>Perspiciatis fugiat nam odit blanditiis corporis ad reiciendis ratione voluptatem ullam sunt
                            consectetur
                            commodi. Consectetur adipisicing elit. Cupiditate, adipisci magni in explicabo facilis deleniti
                            vel </p>
                    </div>
                    <div class="gaps size-x2"></div>
                </div>
                <div class="col-md-6 res-m-bttm">
                    <div class="single-faq mr-x2">
                        <h5 class="faq-heading">How to make a passive income with bitcoin mining ?</h5>
                        <p>Consectetur adipisicing elit. Cupiditate, adipisci magni in explicabo facilis deleniti vel
                            perspiciatis
                            fugiat nam odit blanditiis corporis ad reiciendis ratione voluptatem ullam sunt consectetur
                            commodi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section -->
@endsection
