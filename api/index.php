<?php

$url = 'https://gasell1.zavann.se/rest/v2/hourlyspotprice?from_date=2019-07-01&to_date=2019-07-31';
$username = 'svea_solar';
$password = 'shae2Che';

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
print_r($curl_response);