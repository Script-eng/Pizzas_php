<?php
// soap_client.php

function getExchangeRate($currencyPair, $date) {
    // Split the currency pair (e.g., EUR-HUF)
    $currencies = explode('-', $currencyPair);
    $fromCurrency = $currencies[0];
    $toCurrency = $currencies[1];

    try {
        // Create a new SOAP client instance with the MNB WSDL URL
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

        // Construct the request body according to the SOAP API specification
        $params = [
            'startDate' => $date,
            'endDate' => $date,
            'currencyNames' => $fromCurrency . ',' . $toCurrency,
        ];

        // Call the GetExchangeRates method with the parameters
        $response = $client->GetExchangeRates($params);

        // Parse the XML response
        $xml = simplexml_load_string($response->GetExchangeRatesResult);
        $rate = (string) $xml->Day->Rate;  // Adjust this based on the actual structure of the response

        return $rate;
    } catch (SoapFault $fault) {
        // Handle SOAP exceptions
        echo "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
        return null;
    }
}

// Function to check available methods for debugging purposes
function checkAvailableFunctions() {
    try {
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

        // Fetch and print the available functions from the SOAP service
        $functions = $client->__getFunctions();
        foreach ($functions as $function) {
            echo $function . "<br>";
        }
    } catch (SoapFault $fault) {
        echo "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
    }
}

// Uncomment the line below to check available methods
// checkAvailableFunctions();
