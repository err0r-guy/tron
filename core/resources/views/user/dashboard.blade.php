@extends('layouts.app')

@section('addCss')
    <style>
        .btn.ud-btn:hover,
        .btn.ud2-btn {
            color: #145DCC;
        }

        .btn.ud2-btn:hover {
            color: #ffffff;
        }
    </style>
@endsection

@section('addJs')
    <script>
        $(document).ready(function() {
            let speed = (parseFloat({{ $userEarningRate }}) / 3600).toFixed(8);
            console.log(speed);
            setInterval(function() {
                let oldvalue = parseFloat($('#bal').html()).toFixed(8);
                let result = parseFloat(parseFloat(oldvalue) + parseFloat(speed)).toFixed(8);
                $("#bal").html(result);
            }, 1000);
        });
    </script>
@endsection

@section('banner')
    <!-- Banner/Slider -->
    <div class="page-head section row-vm light">
        <div class="imagebg">
            <img src="{{ asset('assets/images/user-inside.jpg') }}" alt="page-head">
        </div>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2>{{ $page_title }}</h2>

                    <a href="{{ route('user.withdraw') }}" class="btn ud-btn">Withdral</a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                        class="btn btn-outline ud2-btn">{{ __('Logout') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- #end Banner/Slider -->
@endsection

@section('content')
    <!-- Features Box -->
    <div class="features-box section section-pad no-pb">
        <div class="container">
            <div class="row text-center">
                {{-- Notification --}}
                @if (empty(Auth::user()->email))
                    <div class="col-md-12 res-m-bttm">
                        <div class="pricing-box round shadow" style="padding: 35px 10px">
                            <p class="small" style="font-weight: 500;">You must enter a valid email address, otherwise you
                                will
                                not be able to regain
                                access to your account if you forget your password. <a
                                    href="{{ route('user.profile') }}">Click here</a> to update
                                your email.</p>
                        </div>
                    </div>
                @endif

                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 res-m-bttm">
                    <div class="box round shadow-alt">
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('assets/images/box-icon-a.png') }}" alt="box-icon"
                                style="max-width: 100%; width: 35px; margin: 10px;">
                            <h5 class="ucap" style="margin-top: 15px;">Balance</h5>
                        </div>
                        <h4 style="font-weight: 800"> <span id="bal">{{ Auth::user()->balance }}</span>
                            {{ $settings->cur_sym }}
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 res-m-bttm">
                    <div class="box round shadow-alt">
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('assets/images/box-icon-f.png') }}" alt="box-icon"
                                style="max-width: 100%; width: 35px; margin: 10px;">
                            <h5 class="ucap" style="margin-top: 15px;">Wallet Address</h5>
                        </div>
                        <h4 style="font-weight: 800; overflow-x: scroll">{{ Auth::user()->username }}</h4>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 res-m-bttm">
                    <div class="box round shadow-alt">
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('assets/images/box-icon-p.png') }}" alt="box-icon"
                                style="max-width: 100%; width: 35px; margin: 10px;">
                            <h5 class="ucap" style="margin-top: 15px;">Refferal Link</h5>
                        </div>
                        {{-- <h4 style="font-weight: 800; overflow-x: scroll">Trdfjgnfoit49iwerhwtoerwhuehfwgw9rfghiefds</h4> --}}
                        <input type="text" id="ref_link" class="form-control"
                            value="{{ config('app.url') }}?ref={{ Auth::user()->uid }}" readonly>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--End Features Box -->

    <!-- Active plan -->
    <div class="features-box section section-pad no-pb">
        <div class="container">
            <div class="faq-one row">
                <div class="col-md-12">
                    <div class="payouts-box">
                        <h4 class="wrap-title">Active Plan</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr style="text-align: center">
                                        <th>Name</th>
                                        <th>Speed</th>
                                        <th>Earning Rate</th>
                                        <th>Start</th>
                                        <th>Time Left</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($userActivePlans as $activePlan)
                                        <tr style="text-align:center">
                                            <td>{{ $activePlan->name }}</td>
                                            <td>{{ $activePlan->speed }}</td>
                                            <td>{{ $activePlan->earning_rate }}</td>
                                            <td>{{ $activePlan->pivot->created_at }}</td>
                                            <td>
                                                {{ $activePlan->pivot->expire_date }}
                                                <br>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success"
                                                        role="progressbar"
                                                        style="width: {{ diffDatePercent($activePlan->pivot->created_at, $activePlan->pivot->expire_date) }}"
                                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                        {{ diffDatePercent($activePlan->pivot->created_at, $activePlan->pivot->expire_date) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $activePlan->pivot->status ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                    @empty
                                        <tr style="text-align: center">
                                            <td colspan="6" class="text-center">No results!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Active Plan -->

    @include('partials.plans')
@endsection
