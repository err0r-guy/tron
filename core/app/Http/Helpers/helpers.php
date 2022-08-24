<?php

use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Get settings value
 *
 * @return response()
 */
if (!function_exists('settings')) {
    function settings($param)
    {
        $settings = Settings::first();
        return $settings->$param;
    }
}

/**
 * Check if user exist
 *
 * @return response()
 */
if (!function_exists('username_check')) {
    function username_check($username)
    {
        $user = User::where('username', $username)->first();
        if ($user) return true;
    }
}

/**
 * get User Agent
 *
 * @return response()
 */
if (!function_exists('userAgent')) {
    function userAgent()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        $browser = "Unknown Browser";
        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        $data['os_platform'] = $os_platform;
        $data['browser'] = $browser;

        return $data;
    }
}

/**
 * update User Balance
 *
 * @return response()
 */
if (!function_exists('updateUserBalance')) {
    function updateUserBalance()
    {
        $userActivePlans = Auth::user()->plans()->wherePivot('status', 1)->get();
        $user = User::find(Auth::user()->id);

        foreach ($userActivePlans as $key => $activePlans) {
            // Disable expired plan
            if ($activePlans->pivot->expire_date !== null && now() >= $activePlans->pivot->expire_date) {
                // set user_plan status = 0
                $user->plans()->newPivotStatement()->where('id', $activePlans->pivot->id)->update(['status' => 0]);
            } else {
                $now = Carbon::now();
                $last_sum = $activePlans->pivot->last_sum ? $activePlans->pivot->last_sum : $activePlans->pivot->created_at;
                $seconds = $now->diffInSeconds($last_sum);
                $earnings = ($seconds * ($activePlans->earning_rate / 3600));
                // Update last_sum
                $user->plans()->newPivotStatement()->where('id', $activePlans->pivot->id)->update(['last_sum' => $now]);
                // Update User Balance
                $user->balance = $user->balance + $earnings;
                $user->save();
            }
        }
    }
}

/**
 * Upload Image
 *
 * @return response()
 */
if (!function_exists('uploadFile')) {
    function uploadFile($file, $location, $old = null)
    {
        $path = makeDirectory($location);
        if (!$path) throw new Exception('File could not been created.');

        if (!empty($old)) {
            removeFile($old);
        }

        $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $finalname = $location . '/' . $filename;
        $file->move($location, $filename);
        return $finalname;
    }
}

/**
 * Create new folder
 *
 * @return response()
 */
if (!function_exists('makeDirectory')) {
    function makeDirectory($path)
    {
        if (file_exists($path)) return true;
        return mkdir($path, 0755, true);
    }
}

/**
 * Delete File
 *
 * @return response()
 */
if (!function_exists('removeFile')) {
    function removeFile($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }
}

function diffDatePercent($start, $end)
{
    $start = strtotime($start);
    $end = strtotime($end);


    $diff = $end - $start;

    $current = time();
    $cdiff = $current - $start;

    if ($cdiff > $diff) {
        $percentage = 1.0;
    } else if ($current < $start) {
        $percentage = 0.0;
    } else {
        $percentage = $cdiff / $diff;
    }

    return sprintf('%.2f%%', $percentage * 100);

    /*
    if($last_time == null){
        $last_time = time();
    }
    $date1 = strtotime($last_time);
    $date2 = strtotime($next_time);
    $today = time();
    if ($today < $date1){
        $percentage = 0;
    }else if ($today > $date2){
        $percentage = 100;
    }else{
        $percentage = ($date2 - $today) * 100 / ($date2 - $date1);
    }
    return round($percentage,2);
    */
}

function base58_encode($string)
{
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    $base = strlen($alphabet);
    if (is_string($string) === false) {
        return false;
    }
    if (strlen($string) === 0) {
        return '';
    }
    $bytes = array_values(unpack('C*', $string));
    $decimal = $bytes[0];
    for ($i = 1, $l = count($bytes); $i < $l; $i++) {
        $decimal = bcmul($decimal, 256);
        $decimal = bcadd($decimal, $bytes[$i]);
    }
    $output = '';
    while ($decimal >= $base) {
        $div = bcdiv($decimal, $base, 0);
        $mod = bcmod($decimal, $base);
        $output .= $alphabet[$mod];
        $decimal = $div;
    }
    if ($decimal > 0) {
        $output .= $alphabet[$decimal];
    }
    $output = strrev($output);
    foreach ($bytes as $byte) {
        if ($byte === 0) {
            $output = $alphabet[0] . $output;
            continue;
        }
        break;
    }
    return (string) $output;
}

function base58_decode($base58)
{
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    $base = strlen($alphabet);
    if (is_string($base58) === false) {
        return false;
    }
    if (strlen($base58) === 0) {
        return '';
    }
    $indexes = array_flip(str_split($alphabet));
    $chars = str_split($base58);
    foreach ($chars as $char) {
        if (isset($indexes[$char]) === false) {
            return false;
        }
    }
    $decimal = $indexes[$chars[0]];
    for ($i = 1, $l = count($chars); $i < $l; $i++) {
        $decimal = bcmul($decimal, $base);
        $decimal = bcadd($decimal, $indexes[$chars[$i]]);
    }
    $output = '';
    while ($decimal > 0) {
        $byte = bcmod($decimal, 256);
        $output = pack('C', $byte) . $output;
        $decimal = bcdiv($decimal, 256, 0);
    }
    foreach ($chars as $char) {
        if ($indexes[$char] === 0) {
            $output = "\x00" . $output;
            continue;
        }
        break;
    }
    return $output;
}

//encode address from byte[] to base58check string
function base58check_en($address)
{
    $hash0 = hash("sha256", $address);
    $hash1 = hash("sha256", hex2bin($hash0));
    $checksum = substr($hash1, 0, 8);
    $address = $address . hex2bin($checksum);
    $base58add = base58_encode($address);
    return $base58add;
}

//decode address from base58check string to byte[]
function base58check_de($base58add)
{
    $address = base58_decode($base58add);
    $size = strlen($address);
    if ($size != 25) {
        return false;
    }
    $checksum = substr($address, 21);
    $address = substr($address, 0, 21);
    $hash0 = hash("sha256", $address);
    $hash1 = hash("sha256", hex2bin($hash0));
    $checksum0 = substr($hash1, 0, 8);
    $checksum1 = bin2hex($checksum);
    if (strcmp($checksum0, $checksum1)) {
        return false;
    }
    return $address;
}

function hexString2Base58check($hexString)
{
    $address = hex2bin($hexString);
    $base58add = base58check_en($address);
    return $base58add;
}

function base58check2HexString($base58add)
{
    $address = base58check_de($base58add);
    $hexString = bin2hex($address);
    return $hexString;
}

function hexString2Base64($hexString)
{
    $address = hex2bin($hexString);
    $base64 = base64_encode($address);
    return $base64;
}

function base642HexString($base64)
{
    $address = base64_decode($base64);
    $hexString = bin2hex($address);
    return $hexString;
}

function base58check2Base64($base58add)
{
    $address = base58check_de($base58add);
    $base64 = base64_encode($address);
    return $base64;
}

function base642Base58check($base64)
{
    $address = base64_decode($base64);
    $base58add = base58check_en($address);
    return $base58add;
}

function VerifyToken($TransactionId)
{

    //$url = "https://tronscan.org/#/transaction/".$TransactionId;
    $url = "https://apilist.tronscan.org/api/transaction-info?hash=" . $TransactionId;

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $data = json_decode($Currencies, true);
    //echo $Currencies;
    return $data;
}

function GetTransactionById($TransactionId)
{

    $payload = '{"value":"' . $TransactionId . '"}';

    $url = "https://api.trongrid.io/wallet/gettransactionbyid";
    // Test Server
    // $url = "https://api.shasta.trongrid.io/wallet/gettransactionbyid";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    echo $Currencies;

    $data = json_decode($Currencies, true);
    return $data;
}

function ValidateAddress($address)
{

    $address = base58check2HexString($address);

    $payload = '{"address":"' . $address . '"}';

    $url = "https://api.shasta.trongrid.io/wallet/validateaddress";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $data = json_decode($Currencies, true);
    return $data;
}

function EasyTransferByPrivate($toAddress, $amount)
{
    $privateKey = settings('pri_key');
    $toAddress = base58check2HexString($toAddress);
    $amount = $amount * 1000000;

    $payload = '{"privateKey": "' . $privateKey . '","toAddress":"' . $toAddress . '","amount": ' . $amount . '}';

    $url = "https://api.trongrid.io/wallet/easytransferbyprivate";

    //Test Server
    // $url = "https://api.shasta.trongrid.io/wallet/easytransferbyprivate";
    // $url = "http://3.225.171.164:8090/wallet/easytransferbyprivate";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    // echo ($Currencies);

    $data = json_decode($Currencies, true);
    return $data;
}

function CreateTransaction($ownerAddress, $amount, $toAddress)
{
    $toAddress = base58check2HexString($toAddress);
    $ownerAddress = base58check2HexString($ownerAddress);
    // dd($ownerAddress);
    $amount = $amount * 1000000;

    $payload = '{"to_address": "' . $toAddress . '", "owner_address": "' . $ownerAddress . '", "amount": ' . $amount . '}';
    // dd($payload);

    $url = "https://api.trongrid.io/wallet/createtransaction";
    //Test Server
    // $url = "https://api.shasta.trongrid.io/wallet/createtransaction";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    // echo ($Currencies);

    $data = json_decode($Currencies, true);
    return $data;
}

function GetTransactionSign($transaction)
{
    $privateKey = settings('pri_key');

    $payload = '{"transaction": ' . $transaction . ', "privateKey": "' . $privateKey . '"}';
    // echo $payload;
    // exit();

    $url = "https://api.shasta.trongrid.io/wallet/gettransactionsign";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    // echo ($Currencies);

    $data = json_decode($Currencies, true);
    return $data;
}

function BroadcastTransaction($transaction)
{
    $privateKey = settings('pri_key');

    $payload = $transaction;

    $url = "https://api.trongrid.io/wallet/broadcasttransaction";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'TRON-PRO-API-KEY: ' . settings('trongrid_api')
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    // echo ($Currencies);

    $data = json_decode($Currencies, true);
    return $data;
}
