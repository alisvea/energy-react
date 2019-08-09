<?php

class SpotPrice {

    private $fileName = '';

    function __construct($zone)
    {
        $month_start = new DateTime("first day of last month");
        $this->fileName = $month_start->format('mY') . '.json';
        $result = '';

        if(file_exists($this->fileName)) {
            $contents = file_get_contents($this->fileName);
            $jsonData = json_decode($contents, true);
            header('Content-Type: application/json');
            $result = $this->calculateAverageForZone($jsonData, $zone);

        } else {
            $jsonData = makeCurlRequest();
            header('Content-Type: application/json');
            $result = $this->calculateAverageForZone($jsonData, $zone);
        }

        $this->sendData([
            'zone' => $zone,
            'spot_price' => number_format($result,2)
        ]);
    }

    private function sendData($result) {
        header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // Finds average of all hours for a day in a zone
    private function getAverageForDay($zone, $date, $data) {
        if( ! isset($data[$zone]) ) {
            // echo 'Zone not set';
            return 0;
        }

        if( ! isset($data[$zone][$date]) ) {
            return 0;
        }

        $month_data = $data[$zone][$date];
        $sum = 0;

        foreach ($month_data as $day => $rate) {
            $sum += $rate['price_including_vat'];
        }

        $average = ( $sum / count($month_data));

        return $average;
    }


    // Finds average for all days in a zone
    public function calculateAverageForZone($jsonData, $zone) {

        $month_start = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $startDayString = $month_start->format('Y-m');
        $lastDay = $month_end->format('d');

        // echo $startDayString . PHP_EOL;
        // echo $lastDay . PHP_EOL;
        $count = 0;
        $total_average = 0;

        for($i = 1; $i <= $lastDay; $i++) {
            $day = $i < 10 ? '0' . $i : $i;
            $average = $this->getAverageForDay($zone, "2019-07-$day", $jsonData);

            if( $average > 0) {
                $count++;
                $total_average += $average;
            }
            // echo PHP_EOL;
        }

        return round(($total_average / $count), 2);
    }

    function makeCurlRequest()
    {
        $month_start = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $firstDayOfMonth = $month_start->format('Y-m-d');
        $lastDayOfMonth = $month_end->format('Y-m-d');
        $url = "https://gasell1.zavann.se/rest/v2/hourlyspotprice?from_date={$firstDayOfMonth}&to_date={$lastDayOfMonth}";

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
            // echo "Request successful<br/>";
        }

        file_put_contents($this->fileName, $curl_response);

        return $curl_response;
    }
}


// respond to preflights
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // return only the headers and not the content
    // only allow CORS if we're doing a GET - i.e. no saving for now.
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With');
    }
    exit;
}

$zone = isset($_GET['zone']) ? $_GET['zone'] : 'SE1';
$spot_price = new SpotPrice($zone);

