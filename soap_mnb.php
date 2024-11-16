<pre>
<?php
// Soap Client initialization
$client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

// Function to get exchange rate on a specific day
function getExchangeRateForDay($currencyPair, $date) {
    try {
        // Fetch exchange rates from SOAP service
        $response = $client->GetCurrentExchangeRates();
        $rates = simplexml_load_string($response->GetCurrentExchangeRatesResult);
        $ratesArray = (array)$rates;

        // Search for the exchange rate for the given currency pair on the specified date
        foreach ($ratesArray['Day'] as $day) {
            if ($day['date'] == $date) {
                foreach ($day['rates'] as $rate) {
                    if ($rate['currency'] == $currencyPair) {
                        return $rate;
                    }
                }
            }
        }

        return "No data found for this date or currency pair.";
    } catch (SoapFault $e) {
        return "Error: " . $e->getMessage();
    }
}

// Example of how to call the function
$currencyPair = 'EURHUF'; // Example: EUR-HUF
$date = '2024-11-15'; // Example: 2024-11-15
$rate = getExchangeRateForDay($currencyPair, $date);

echo "<h3>Exchange rate for $currencyPair on $date:</h3><pre>" . htmlspecialchars(print_r($rate, true)) . "</pre>";
?>
</pre>
