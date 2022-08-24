<!--Section -->
<div class="section section-pad">
    <div class="container">
        <div class="section-head">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2 class="heading-section">Find the right plan</h2>
                </div>
                <div class="gaps size-1x"></div>
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <p>Cloud mining is greatly suited for novice miners who would like to try out mining and earning
                        cryptocurrency as well as seasoned miners
                        who don't want the hassle or risks of hosted or home-based mining.</p>
                </div>
            </div>
        </div>
        <div class="gaps size-3x"></div>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 res-m-bttm">
                    <div class="box-miner">
                        <h4 class="box-miner-title text-center">{{ $plan->name }}</h4>
                        <div class="box-miner-image">
                            <img src="{{ asset($plan->image) }}" alt="{{ $plan->name }}">
                        </div>
                        <ul class="box-miner-list">
                            <li>
                                <div class="row no-mg">
                                    <div class="col-xs-5 no-pd">Mining</div>
                                    <div class="col-xs-7 no-pd text-right">{{ $plan->earning_rate }}
                                        {{ $settings->cur_sym }}/{{ $plan->speed == '1' ? 'Hour' : $plan->speed . 'Hours' }}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row no-mg">
                                    <div class="col-xs-6 no-pd">Price </div>
                                    <div class="col-xs-6 no-pd text-right">
                                        {{ $plan->price == 0 ? 'Free Plan' : $plan->price . ' ' . $settings->cur_sym }}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row no-mg">
                                    <div class="col-xs-6 no-pd">Contract length</div>
                                    <div class="col-xs-6 no-pd text-right">{{ $plan->period }} Month(s)</div>
                                </div>
                            </li>
                            <li>
                                @guest
                                    <a class="box-miner-action" href="#signup">Sign Up</a>
                                @else
                                    <a class="box-miner-action" href="{{ route('user.plan.upgrade', $plan->id) }}">Upgrade</a>
                                @endguest
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- col -->
            @endforeach
        </div>
        <div class="gaps size-2x"></div>
        <div class="gaps size-4x hidden-xs hidden-sm"></div>
    </div>
</div>
<!--End Section -->
