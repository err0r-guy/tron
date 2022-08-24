<?php

namespace App\Http\Controllers\nowpayments;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\IpnErrorLog;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function confirmPayment($payment_id, $order_id, $planPrice)
    {
        $nwp = new NowPaymentsAPI(settings('nw_key'));
        $payStatus = $nwp->getPaymentStatus($payment_id);
        $payStatus = json_decode($payStatus, true);
        $planPrice = $planPrice * 1;
        // dd($planPrice);
        if ($payStatus['payment_status'] === 'finished' && $payStatus['pay_amount'] >= $planPrice) {

            //Get transaction
            $transaction = Transaction::where('hash', $order_id)->first();
            //Check if transaction already processed
            if ($transaction->status == 1) {
                return $this->errLog('Transaction already paid!', $transaction->id, null, $order_id);
            }

            // payment successfull
            // Update transaction
            $transact = Transaction::find($transaction->id);
            $transact->paid_amount = $payStatus['pay_amount'];
            $transact->txid = $payStatus['payment_id'];
            $transact->status = 1;
            $transact->save();

            //Create deposit history
            $deposit = new Deposit;
            $deposit->user_id = $transaction->user_id;
            $deposit->amount = $payStatus['pay_amount'];
            $deposit->trx = $payStatus['payment_id'];
            $deposit->status = 1;
            $deposit->save();

            // Activate user plan
            $plan = Plan::find($transaction->plan_id);
            $user = User::find($transaction->user_id);
            $expirationDate = Carbon::now()->addMonths($plan->period);
            $user->plans()->attach($plan->id, [
                'status' => 1,
                'expire_date' => $expirationDate,
            ]);

            // Check Refferal
            if (!empty($user->ref_id)) {
                $comission = number_format($plan->price * settings('ref_commission') / 100, 8, '.', '');
                // get upline
                $upline = User::where('ref_id', $user->ref_id)->first();
                // credit upline
                $upline->balance = $upline->balance + $comission;
                $upline->ref_earn = $upline->ref_earn + $comission;
                $upline->save();
                // Create referral history
                $reff = new Referral;
                $reff->user_id = $upline->id;
                $reff->amount = $comission;
                $reff->status = 1;
                $reff->save();
            }

            return response()->json([
                'status' => 'finished',
                'redUrl' => route('user.dashboard'),
            ]);
        } else if ($payStatus['payment_status'] == "expired") {
            //Cancelled/expired payment
            //Get transaction
            $transaction = Transaction::where('hash', $order_id)->first();
            //Cancel transaction
            $transact3 = Transaction::find($transaction->id);
            $transact3->status = 2;
            $transact3->save();
        } else {
            return response()->json([
                'status' => 'waiting',
            ]);
        }

    }

    /*
     * NowPayments Gateway
     */
    public function ipn(Request $request)
    {
        $ipn_secret = settings('coin_hash');

        $request_json = file_get_contents('php://input');
        $request_data = json_decode($request_json, true);
        ksort($request_data);
        $sorted_request_json = json_encode($request_data, JSON_UNESCAPED_SLASHES);

        if ($request_json === false && empty($request_json)) {
            return $this->errorAndDie('Error reading POST data', null, null, $sorted_request_json['order_id']);
        }

        if (!isset($_SERVER['HTTP_X_NOWPAYMENTS_SIG']) && empty($_SERVER['HTTP_X_NOWPAYMENTS_SIG'])) {
            $error_msg = 'No HMAC signature sent.';
            return $this->errorAndDie($error_msg, null, null, $sorted_request_json['order_id']);
        }

        $recived_hmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'];
        $hmac = hash_hmac("sha512", $sorted_request_json, trim($ipn_secret));
        if ($hmac == $recived_hmac) {

            //Get transaction
            $transaction = Transaction::where('hash', $sorted_request_json['order_id'])->first();
            if (!$transaction) {
                return $this->errorAndDie('Transaction not found!', null, null, $sorted_request_json['order_id']);
            }
            //Check if transaction already processed
            if ($transaction->status == 1) {
                return $this->errorAndDie('Transaction already paid!', $transaction->id, null, $sorted_request_json['order_id']);
            }
            //Payment awaiting confirmations
            if ($sorted_request_json['payment_status'] == "waiting") {
                //Update transaction
                $transact2 = Transaction::find($transaction->id);
                $transact2->status = 0;
                $transact2->save();
            }
            //Cancelled/expired payment
            if ($sorted_request_json['payment_status'] == "expired") {
                //Cancel transaction
                $transact3 = Transaction::find($transaction->id);
                $transact3->status = 2;
                $transact3->save();
            }

            if ($sorted_request_json['payment_status'] == 'confirmed') {
                // payment successfull
                // Update transaction
                $transact = Transaction::find($transaction->id);
                $transact->paid_amount = $sorted_request_json['pay_amount'];
                $transact->txid = $sorted_request_json['payment_id'];
                $transact->status = 1;
                $transact->save();

                //Create deposit history
                $deposit = new Deposit;
                $deposit->user_id = $transaction->user_id;
                $deposit->amount = $sorted_request_json['pay_amount'];
                $deposit->trx = $sorted_request_json['payment_id'];
                $deposit->status = 1;
                $deposit->save();

                // Activate user plan
                $plan = Plan::find($transaction->plan_id);
                $user = User::find($transaction->user_id);
                $expirationDate = Carbon::now()->addMonths($plan->period);
                $user->plans()->attach($plan->id, [
                    'status' => 1,
                    'expire_date' => $expirationDate,
                ]);

                // Check Refferal
                if (!empty($user->ref_id)) {
                    $comission = number_format($plan->price * settings('ref_commission') / 100, 8, '.', '');
                    // get upline
                    $upline = User::where('ref_id', $user->ref_id)->first();
                    // credit upline
                    $upline->balance = $upline->balance + $comission;
                    $upline->ref_earn = $upline->ref_earn + $comission;
                    $upline->save();
                    // Create referral history
                    $reff = new Referral;
                    $reff->user_id = $upline->id;
                    $reff->amount = $comission;
                    $reff->status = 1;
                    $reff->save();
                }
                die('IPN OK');
            }

        } else {
            $error_msg = 'HMAC signature does not match';
            return $this->errorAndDie($error_msg, null, null, $sorted_request_json['order_id']);
        }

    }

    protected function errorAndDie($error_msg, $tid = null, $status = null, $params = null)
    {
        // Insert ipn error into db
        $errLog = new IpnErrorLog;
        $errLog->transaction_id = $tid;
        $errLog->message = $error_msg;
        $errLog->content = json_encode($params);
        $errLog->status = $status;
        $errLog->save();

        die('IPN Error: ' . $error_msg);
    }

    protected function errLog($error_msg, $tid = null, $status = null, $params = null)
    {
        // Insert ipn error into db
        $errLog = new IpnErrorLog;
        $errLog->transaction_id = $tid;
        $errLog->message = $error_msg;
        $errLog->content = json_encode($params);
        $errLog->status = $status;
        $errLog->save();

        return response()->json([
            'status' => 'error',
            'errmessage' => $error_msg,
        ]);
    }
}
