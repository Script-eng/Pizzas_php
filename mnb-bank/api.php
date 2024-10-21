<?php
// api.php
include 'soap_client.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['currency_pair']) && isset($_GET['date'])) {
        $currencyPair = $_GET['currency_pair'];
        $date = $_GET['date'];
        $rate = getExchangeRate($currencyPair, $date);
        echo json_encode(array('rate' => $rate->GetExchangeRateResult));
    }
}
?>
