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
<div class="section section-pad">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h4>Request Withdraw</h4>
                <p>Request withdraw of your earnings to your <?php echo settings('currency_name');?> Wallet.</p>
            </div>
        </div>

        <div class="gaps size-2x"></div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                {{--  <h3>Your earning balance: {{ Auth::user()->balance }} {{ settings('cur_sym') }}</h3>  --}}
                <br>
                <div class="col-md-6">
                    <div class="alert alert-success"><b>Min:</b> {{ settings('min_withdraw') }} {{ settings('cur_sym') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info"><b>Max:</b> {{ settings('max_withdraw') }} {{ settings('cur_sym') }}</div>
                </div>
                <form action="{{ route('user.withdraw') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Amount to Withdraw</label>
                        <input type="text" id="amount" name="amount" placeholder="1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Address</label>
                        <input value="{{ Auth::user()->username }}" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-success ud-btn"><i class="fa fa-send"></i> Confirm Withdrawal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
