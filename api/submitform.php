
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($_POST));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);
    //Access-Control-Allow-Origin header with wildcard.
    header('Access-Control-Allow-Origin: *');
    print_r($server_output);
    echo "Sent";
    exit;
}
