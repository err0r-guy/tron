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
            <div class="tab-custom">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#refs" data-toggle="tab" aria-expanded="true">Referrals</a></li>
                            <li><a href="#comissions" data-toggle="tab" aria-expanded="true">Refferal Earns</a></li>
                            <li><a href="#deposits" data-toggle="tab" aria-expanded="true">Deposits</a></li>
                            <li><a href="#withdraws" data-toggle="tab" aria-expanded="true">Withdraws</a></li>
                            <li><a href="#transactions" data-toggle="tab" aria-expanded="true">Pending Purchases</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="gaps size-2x"></div>

                <!-- Tab panes -->
                <div class="tab-content no-pd">
                    <!-- START REFS -->
                    <div class="tab-pane fade active in" id="refs">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>User</th>
                                        <th>Date of Joining</th>
                                    </tr>
                                    @forelse ($referrals as $refferal)
                                        <tr>
                                            <th>{{ $refferal->username }}</th>
                                            <th>{{ $refferal->created_at }}</th>
                                        </tr>
                                    @empty
                                        <tr style="text-align:center">
                                            <td colspan="2" class="text-center">No results!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END REFS -->

                    <!-- START REFS EARN -->
                    <div class="tab-pane fade" id="comissions">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($ref_earns as $ref_earn)
                                        <tr>
                                            <th>{{ $ref_earn->created_at }}</th>
                                            <th>{{ $ref_earn->amount }}</th>
                                            <th>{{ $ref_earn->status ? 'Paid' : 'Pending' }}</th>
                                        </tr>
                                    @empty
                                        <tr style="text-align:center">
                                            <td colspan="3" class="text-center">No results!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END REFS EARN -->

                    <!-- START DEPOSIT -->
                    <div class="tab-pane fade" id="deposits">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>TXID</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($deposits as $deposit)
                                        <tr>
                                            <th>{{ $deposit->created_at->diffForHumans() }}</th>
                                            <th>{{ $deposit->amount }}</th>
                                            <th>{{ $deposit->trx }}</th>
                                            <th>{{ $deposit->status == 1 ? 'Paid' : ($deposit == 0 ? 'Pending' : 'Canceled') }}
                                            </th>
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
                    <!-- END DEPOSIT -->

                    <!-- START WITHDRAWAL -->
                    <div class="tab-pane fade" id="withdraws">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>TXID</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($withdrawals as $withdrawal)
                                        <tr>
                                            <th>{{ $withdrawal->created_at->diffForHumans() }}</th>
                                            <th>{{ $withdrawal->amount }}</th>
                                            <th>{{ $withdrawal->trx }}</th>
                                            <th>{{ $withdrawal->status == 1 ? 'Paid' : ($deposit == 0 ? 'Pending' : 'Canceled') }}
                                            </th>
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
                    <!-- END WITHDRAWAL -->

                    <!-- START TRANSACTIONS -->
                    <div class="tab-pane fade" id="transactions">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <th>{{ $transaction->created_at->diffForHumans() }}</th>
                                            <th>{{ $transaction->amount }}</th>
                                            <th>{{ $transaction->status == 1 ? 'Paid' : ($deposit->status == 0 ? 'Pending' : 'Canceled') }}
                                            </th>
                                        </tr>
                                    @empty
                                        <tr style="text-align:center">
                                            <td colspan="3" class="text-center">No results!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TRANSACTIONS -->
                </div>

            </div>
        </div>
    </div>
    <!-- End Section -->
@endsection
