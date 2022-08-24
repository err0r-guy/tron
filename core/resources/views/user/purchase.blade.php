@extends('layouts.app')

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
                <div class="col-md-12 text-center">
                    <h4>{{ $page_title }}</h4>
                    <div class="gaps size-1x"></div>
                </div>
            </div>
            <div class="faq-one row">
                <div class="col-md-12">
                    <div class="payouts-box">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h2>Complete Your Purchase</h2>
                            </div>
                            <div class="panel-body">
                                <p class="list-group-item"><b>Purchase Price:</b> {{ $invoice['amount'] }}
                                    {{ settings('cur_sym') }}
                                </p>
                                <p class="list-group-item"><b>Payment Address:</b>
                                    <input class="form-control" onclick="this.select();"
                                        value="{{ $params['pay_address'] }}" readonly>
                                    <span class="help-block">* Click to select all</span>
                                </p>
                                <p class="list-group-item">
                                    <b>Instructions:</b><br>
                                    Send exactly <b>{{ $params['pay_amount'] }}</b> {{ $params['pay_currency'] }} to
                                    above address.<br><br>
                                    <b>Description:</b><br>
                                    {{ $params['order_description'] }}.<br><br>
                                </p>
                            </div>
                        </div>
                        <div>
                            <p>Click on the button below to confirm your payment.Please do not not close the page</p>
                            <button class="btn btn-primary ud-btn" id="checkStatus">Confirm Payment</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--  {{ dd() }}  --}}
        </div>
    </div>
    <!-- End Section -->
@endsection

@section('addJs')
    <script>
        $('#checkStatus').on('click', () => {
            $.ajax({
                url: "{{ route('ipn.confirmPayment', ['payment_id' => $params['payment_id'], 'order_id' => $params['order_id'], 'planPrice' => $invoice['amount']]) }}",
                type: 'GET',
                success: function(json) {
                    console.log(json);
                    if (json.status == 'finished') {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success("Payment Confirmed successfully");
                        window.location.replace(json.redUrl);
                    } else if (json.status == 'error') {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.warning("${json.errmessage}");
                    } else {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.info("Your payment is still awaiting confimation, click on the button again in 2 mins.");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        });
    </script>
@endsection
