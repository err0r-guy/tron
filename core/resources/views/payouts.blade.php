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
                <div class="col-md-12 text-center">
                    <h4>{{ $page_title }}</h4>
                    <div class="gaps size-1x"></div>
                </div>
            </div>
            <div class="faq-one row">
                <div class="col-md-12">
                    <div class="payouts-box">

                        <h4 class="wrap-title">{{ count($withdrawals) }} Last Payouts</h4>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Address</th>
                                        <th>TXID</th>
                                    </tr>
                                    @forelse ($withdrawals as $withdraw)
                                        <tr>
                                            <th>{{ $withdraw->created_at->diffForHumans() }}</th>
                                            <th>{{ $withdraw->amount }}</th>
                                            <th>{{ $withdraw->user->username }}</th>
                                            <th>{{ $withdraw->trx }}</th>
                                        </tr>
                                    @empty
                                        <tr style="text-align:center">
                                            <td colspan="4" class="text-center">No results!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <h4 class="wrap-title">{{ count($deposits) }} Last Deposits</h4>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Address</th>
                                        <th>TXID</th>
                                    </tr>
                                    @forelse ($deposits as $deposit)
                                        <tr>
                                            <th>{{ $deposit->created_at->diffForHumans() }}</th>
                                            <th>{{ $deposit->amount }}</th>
                                            <th>{{ $deposit->user->username }}</th>
                                            <th>{{ $deposit->trx }}</th>
                                        </tr>
                                    @empty
                                        <tr style="text-align:center">
                                            <td colspan="4" class="text-center">No results!</td>
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
    <!-- End Section -->
@endsection
