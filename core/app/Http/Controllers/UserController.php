<?php

namespace App\Http\Controllers;

use App\Http\Controllers\nowpayments\NowPaymentsAPI;
use App\Models\Deposit;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['page_title'] = 'Dashboard';
        $data['userActivePlans'] = Auth::user()->plans()->wherePivot('status', 1)->get();
        $data['userEarningRate'] = $data['userActivePlans']->sum('earning_rate');
        updateUserBalance();
        return view('user.dashboard', $data);
    }

    public function profile()
    {
        $page_title = 'User Profile';
        return view('user.profile', compact('page_title'));
    }

    public function profileUpdate(Request $request)
    {
        if (!empty($request->password)) {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'string|min:8',
                'password_confirmation' => 'same:password',
                'current_password' => 'required|min:8',
            ], [
                'current_password.required' => 'Current password is required',
                'current_password.min' => 'Current password needs to have at least 8 characters',
                'password.min' => 'New Password needs to have at least 8 characters',
                'password_confirmation.same' => 'Passwords do not match',
            ]);
        } else {
            $validated = $request->validate([
                'email' => 'required|email',
                'current_password' => 'required|min:8',
            ], [
                'current_password.required' => 'Current password is required',
                'current_password.min' => 'Current password needs to have at least 8 characters',
            ]);
        }

        $currUser = Auth::user();

        if (!empty($request->password)) {
            $current_password = $currUser->password;
            if (!(Hash::check($request->input('current_password'), $current_password))) {
                return back()->withErrors('Please enter correct current password.');
            }
        }

        $user_id = $currUser->id;
        $obj_user = User::find($user_id);
        $obj_user->email = $request->email;
        if (!empty($request->password)) {
            $obj_user->password = Hash::make($request->input('password'));
        }
        $obj_user->save();

        return redirect(route('user.dashboard'))->with('success', 'Updated Successfully');
    }

    public function transactions()
    {
        $data['page_title'] = 'Transactions History';
        $data['transactions'] = Transaction::where('status', '!=', 1)->get();
        $data['deposits'] = Deposit::where('user_id', Auth::user()->id)->get();
        $data['withdrawals'] = Withdraw::where('user_id', Auth::user()->id)->get();
        $data['referrals'] = User::where('ref_id', Auth::user()->uid)->get();
        $data['ref_earns'] = Referral::where('user_id', Auth::user()->id)->get();
        return view('user.transactions', $data);
    }

    public function upgradePlan($plan_id)
    {
        $plan = Plan::findOrFail($plan_id);
        $user = Auth::user();

        $CurrPlan = $user->plans()->wherePivot('plan_id', $plan_id)->first();
        if ($CurrPlan) {
            return back()->with('warning', 'Plan already exist!');
        }

        // check user email
        if (empty($user->email)) {
            return back()->with('warning', 'Update your email');
        }

        $charge = $plan->price * settings('gateway_charge') / 100;
        $payable = $plan->price + $charge;
        $final_amount = $payable;

        $nwp = new NowPaymentsAPI(settings('nw_key'));
        $callbackUrl = route('ipn.nowpayments');
        $hash = md5(settings('coin_hash') . time());

        $nwpStatus = $nwp->status();
        $nwpStatus = json_decode($nwpStatus, true);
        // dd($nwpStatus);
        if (isset($nwpStatus) && $nwpStatus['message'] !== 'OK') {
            return back()->with('error', 'Something went wrong!');
        }
        $nwpGetCurr = $nwp->getCurrencies();
        $nwpGetCurr = json_decode($nwpGetCurr, true);
        if (isset($nwpGetCurr['currencies']) && !in_array(strtolower(settings('cur_sym')), $nwpGetCurr['currencies'])) {
            return back()->with('error', 'Sorry, Payment in ' . settings('cur_sym') . ' not available at the moment!');
        }

        $paramsEs = [
            'amount' => $final_amount,
            'currency_from' => strtolower(settings('cur_sym')),
            'currency_to' => 'usd',
        ];
        $getEstPrice = $nwp->getEstimatePrice($paramsEs);
        // dd($getEstPrice);
        $fires = json_decode($getEstPrice, true);
        $final_amount = $fires['estimated_amount'];

        $params = [
            'price_amount' => $final_amount,
            'price_currency' => 'usd',
            'pay_currency' => strtolower(settings('cur_sym')),
            'pay_amount' => $plan->price,
            'ipn_callback_url' => $callbackUrl,
            'order_id' => $hash,
            'order_description' => 'Purchased ' . $plan->name . ' on ' . settings('sitename'),
        ];
        // dd($params);

        $result = $nwp->createPayment($params);
        $result = json_decode($result, true);
        // dd($result);
        if (isset($result['status']) && $result['status'] == 'failed ') {
            return redirect(route('user.dashboard'))->with('error', 'Transaction Failed!');
        }

        // Transaction History
        $tranHistory = new Transaction;
        $tranHistory->plan_id = $plan->id;
        $tranHistory->user_id = $user->id;
        $tranHistory->amount = $result['pay_amount'];
        $tranHistory->hash = $hash;
        $tranHistory->params = json_encode($result);
        $tranHistory->status = 0;
        $tranHistory->save();

        return redirect(route('user.plan.invoice', $hash));

        // return redirect($result['invoice_url']);

        // return redirect(route('user.dashboard'));
    }

    public function invoice($hash)
    {
        $transaction = Transaction::where('hash', $hash)->firstOrFail();
        if ($transaction->status == 1) {
            return redirect(route('user.dashboard'))->with('warning', 'You have alrady paid for this transaction');
        }

        // You can check transaction expire date if using it here!

        $data['invoice'] = $transaction;
        $data['params'] = json_decode($transaction['params'], true);
        $data['page_title'] = 'Plan Invoice';
        return view('user.purchase', $data);
    }

    public function withdraw()
    {
        // $now = Carbon::now();
        // $last = Carbon::parse('2022-07-08 07:29:16');
        // $res = $now > $last->addDay() ? "You can with" : "no";
        // dd($res);
        $page_title = 'Withdraw';
        return view('user.withdraw', compact('page_title'));
    }

    public function withdrawInsert(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:' . settings('min_withdraw') . '|max:' . settings('max_withdraw'),
        ]);

        $user = Auth::user();

        // check withdrawal in 24 hours
        $chW = Withdraw::where('user_id', $user->id)->latest()->first();
        if ($chW) {
            $now = Carbon::now();
            $lastUserW = Carbon::parse($chW->created_at);
            if ($now < $lastUserW->addDay()) {
                return back()->with('error', 'You can withdraw once in 24 hours');
            }
        }

        // check user email
        if (empty($user->email)) {
            return back()->with('warning', 'Update your email');
        }

        if ($request->amount > $user->balance) {
            return back()->with('error', 'You don\'t have enough earning balance to withdrawal the given amount!');
        }

        $charge = ($request->amount * settings('charge')) / 100;
        $payable = $request->amount + $charge;
        if ($payable > $user->balance) {
            return back()->with('error', 'Withdraw a lesser amount');
        }

        $transResult = CreateTransaction(settings('pub_key'), $request->amount, $user->username);
        // dd($transResult);
        if (empty($transResult) || isset($transResult['Error'])) {
            return back()->with('error', 'Something went wrong');
        }

        $signTrans = GetTransactionSign(json_encode($transResult));
        // dd(json_encode($signTrans));
        $bdTrans = BroadcastTransaction(json_encode($signTrans));
        // dd($bdTrans);

        if (!isset($bdTrans['result']) || !$bdTrans['result']) {
            return back()->with('error', 'Something went wrong');
        }

        // Create withdrawal
        $withdraw = new Withdraw;
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->trx = $bdTrans['txid'];
        $withdraw->status = 1;
        $withdraw->save();

        // Dedut from user balance
        $userA = User::find($user->id);
        $userA->balance = $user->balance - $payable;
        $userA->save();

        return back()->with('success', 'Withdraw requested successfully!');
    }
}
