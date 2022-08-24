@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <!-- Dashboard Logs -->
        <div class="col-xl-6 col-md-6">
            <div class="card social-card text-dark">
                <div class="card-block">
                    <div class="text-center">
                        <i class="fa fa-calendar-check-o f-34 text-custom social-icon"></i>
                        <div>
                        </div>
                        <h3 class="m-b-35">Pending Withdrawals</h3>
                        <h2 class="m-b-0">{{ $countWithdraw }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card social-card text-dark">
                <div class="card-block">
                    <div class="text-center">
                        <i class="fa fa-envelope f-34 text-custom social-icon"></i>
                        <div>
                        </div>
                        <h3 class="m-b-35">Unread Messages</h3>
                        <h2 class="m-b-0">{{ $countMessage }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card social-card bg-simple-c-blue">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fa fa-user f-34 text-c-blue social-icon"></i>
                        </div>
                        <div class="col">
                            <h3 class="m-b-35">Total Users</h3>
                            <h2 class="m-b-0">{{ $countUser }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card social-card bg-simple-c-pink">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fa fa-user-secret f-34 text-c-blue social-icon"></i>
                        </div>
                        <div class="col">
                            <h3 class="m-b-35">Total Admins</h3>
                            <h2 class="m-b-0">{{ $countAdmin }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card social-card bg-simple-c-green">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fa fa-server f-34 text-c-blue social-icon"></i>
                        </div>
                        <div class="col">
                            <h3 class="m-b-35">Total Plans</h3>
                            <h2 class="m-b-0">{{ $countPlan }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card social-card text-dark">
                <div class="card-block">
                    <div class="text-center">
                        <i class="fa fa-bank f-34 text-custom social-icon"></i>
                        <div>
                        </div>
                        <h3 class="m-b-35">Total Deposits</h3>
                        <h2 class="m-b-0">{{ $countDeposit }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card social-card text-dark">
                <div class="card-block">
                    <div class="text-center">
                        <i class="fa fa-money f-34 text-custom social-icon"></i>
                        <div>
                        </div>
                        <h3 class="m-b-35">Total Withdrawals</h3>
                        <h2 class="m-b-0">{{ $countWithdrawal }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard Logs  end -->
    </div>
@endsection
