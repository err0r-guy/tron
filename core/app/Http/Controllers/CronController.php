<?php

namespace App\Http\Controllers;

use App\Models\ActivePlan;
use App\Models\User;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $activePlans = ActivePlan::where('status', 1)->get();
        $now = Carbon::now();

        foreach ($activePlans as $activePlan) {
            $user = User::findOrFail($activePlan->user_id);

            // Disable expired plan
            if ($activePlan->expire_date !== null && now() >= $activePlan->expire_date) {
                $setPlanEx = ActivePlan::find($activePlan->id);
                $setPlanEx->status = 0;
                $setPlanEx->save();
            } else {
                // Update User Balance
                $last_sum = $activePlan->last_sum ? $activePlan->last_sum : $activePlan->created_at;
                $minutes = $now->diffInMinutes($last_sum);
                $earnings = ($minutes * ($activePlan->earning_rate / 60));
                dd($minutes);
                // update last_sum
                $upLS = ActivePlan::find($activePlan->id);
                $upLS->last_sum = $now;
                $upLS->save();
                // add to user bal
                $user->balance = $user->balance + $earnings;
                $user->save();
            }
        }

        echo "EXECUTED";
    }
}
