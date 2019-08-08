<?php
$month_start = new DateTime("first day of last month");
$month_end = new DateTime("last day of last month");

$firstDayOfMonth = $month_start->format('Y-m-d');
$lastDayOfMonth = $month_end->format('Y-m-d');

$fileName = $month_start->format('mY') . '.json';
$url = "https://gasell1.zavann.se/rest/v2/hourlyspotprice?from_date={$firstDayOfMonth}&to_date={$lastDayOfMonth}";

$username = 'svea_solar';
$password = 'shae2Che';

header('Content-Type: application/json');

echo $url;
echo PHP_EOL;
echo $fileName;
echo PHP_EOL;



if(file_exists($fileName)) {
    $contents = file_get_contents($fileName);
    echo $contents;

    exit;
}

$curl = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);

$data = array(
    'destination_state_id' => '23'
);
$params = json_encode($data);
// curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

$curl_response = curl_exec($curl);

if ($curl_response === false) {
    echo "Request failed:<br/>";
    echo curl_error($curl);
    exit;
} else {
    echo "Request successful<br/>";
}

file_put_contents($fileName, $curl_response);