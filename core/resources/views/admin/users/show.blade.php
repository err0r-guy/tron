@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.heading')

    <div class="card">
        <div class="card-header">
            <h5>{{ $page_title }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Sign Up Date</th>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        <tr>
                            <th>User Wallet</th>
                            <td>{{ $data->username }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $data->email }}</td>
                        </tr>
                        <tr>
                            <th>Refferals No:</th>
                            <td>0 </td>
                        </tr>
                        <tr>
                            <th>Balance</th>
                            <td>{{ $data->balance . ' ' . $settings->cur_sym }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>User Plans</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Plan Name</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>Expire Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->plans as $userPlan)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $userPlan->name }}</td>
                                <td>{{ $userPlan->pivot->status ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $userPlan->price }}</td>
                                <td>{{ $userPlan->pivot->created_at }}</td>
                                <td>{{ $userPlan->pivot->expire_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No results!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Withdrawals</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>TXID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->withdrawals as $withdrawals)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $withdrawals->created_at }}</td>
                                <td>{{ $withdrawals->amount }}</td>
                                <td>{{ $withdrawals->trx }}</td>
                                <td>{{ $withdrawals->status === 0 ? 'Pending' : ($withdrawals->status === 1 ? 'Paid' : 'Canceled') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No results!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Deposits</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>TXID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->deposits as $deposits)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $deposits->created_at }}</td>
                                <td>{{ $deposits->amount }}</td>
                                <td>{{ $deposits->trx }}</td>
                                <td>{{ $deposits->status === 0 ? 'Pending' : ($deposits->status === 1 ? 'Paid' : 'Canceled') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No results!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
