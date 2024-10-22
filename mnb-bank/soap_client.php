<?php
// soap_client.php

function getMonthlyExchangeRates($currencyPair, $startDate, $endDate) {
    $client = new SoapClient('https://www.mnb.hu/arfolyamok.asmx?WSDL');

    try {
        $response = $client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currencyPair
        ]);

        // Extract the response and parse the exchange rates
        $xml = simplexml_load_string($response->GetExchangeRatesResult);
        $rates = [];

        foreach ($xml->Day as $day) {
            $date = (string) $day['date'];
            $rate = (float) $day->Rate;
            $rates[] = ['date' => $date, 'rate' => $rate];
        }

        return $rates;

    } catch (SoapFault $fault) {
        echo "Error: ", $fault->faultcode, " - ", $fault->faultstring;
    }

    return [];
}
