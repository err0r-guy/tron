<div class="row">
<div class="col-md-12">
    @php
        $today = Carbon\Carbon::now();
        $till = Carbon\Carbon::now()->addMonths($data->period);
        $years = $till->diffInYears($today);
        $months = $till->diffInMonths($today);
        $weeks = $till->diffInWeeks($today);
        $days = $till->diffInDays($today);
        $hours = $till->diffInHours($today);
        $mins = $till->diffInMinutes($today);
        $secs = $till->diffInSeconds($today);
    @endphp
    Todays Date: {{ $today }} <br>
    Duration Date: {{ $till }} <br>
    years: {{ $years }} <br>
    months: {{ $months }} <br>
    weeks: {{ $weeks }} <br>
    days: {{ $days }} <br>
    hours: {{ $hours }} <br>
    mins: {{ $mins }} <br>
    secs: {{ $secs }} <br>
</div>
</div>
