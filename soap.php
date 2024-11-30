<?php

echo "Initializing SOAP Service Debug...<br>";

class MNBController
{
    private $client;

    public function __construct()
    {
        try {
            echo "Creating SOAP Client...<br>";
            $this->client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
            echo "SOAP Client Initialized Successfully!<br>";
        } catch (Exception $e) {
            echo "Error: Failed to initialize SOAP client: " . $e->getMessage() . "<br>";
            exit;
        }
    }

    // Show Daily Exchange Rate
    public function showDailyExchangeRate()
    {
        try {
            echo "Fetching Daily Exchange Rates...<br>";
            $response = $this->client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult;

            echo "Raw XML Response:<br>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";

            // Convert XML response to an associative array
            $exchangeRates = (array)simplexml_load_string($response);

            echo "Converted Exchange Rates Array:<br>";
            echo "<pre>";
            print_r($exchangeRates);
            echo "</pre>";

            // Prepare a variable to store the rates
            $rates = [];

            // Access the Day element from the exchange rates
            $dayData = $exchangeRates['Day'] ?? null;

            if ($dayData) {
                echo "Processing Day Data...<br>";
                foreach ($dayData->Rate as $rate) {
                    $currencyCode = (string)$rate['curr'];
                    $currencyValue = (string)$rate;

                    echo "Currency: $currencyCode, Value: $currencyValue<br>";

                    // Store in the rates array
                    $rates[$currencyCode] = $currencyValue;
                }

                echo "Processed Rates:<br>";
                echo "<pre>";
                print_r($rates);
                echo "</pre>";

                return [
                    'rates' => $rates,
                    'date' => (string)$dayData->attributes()->date,
                ];
            } else {
                echo "No Day Data Found!<br>";
                return [];
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}
