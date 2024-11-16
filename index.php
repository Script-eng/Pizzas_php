<?php

// Get the route from the query string
$route = isset($_GET['route']) ? $_GET['route'] : '';

// Function to fetch exchange rates from the SOAP API
function showDailyExchangeRate($currencyPair, $date) {
    try {
        // Create a new SOAP client
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

        // Get current exchange rates
        $response = $client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult;

        // Convert XML response to an associative array
        $exchangeRates = (array)simplexml_load_string($response);

        // Prepare a variable to store the rates
        $rates = [];

        // Access the Day element from the exchange rates
        $dayData = $exchangeRates['Day'];

        // Loop through the Rate elements to get currency rates
        if (isset($dayData->Rate)) {
            foreach ($dayData->Rate as $rate) {
                $currencyCode = (string)$rate['curr'];
                $currencyValue = (string)$rate;

                // Store in the rates array
                $rates[$currencyCode] = $currencyValue;
            }
        }

        return ['pair' => $currencyPair, 'rates' => $rates];  // Return both pair and rates
    } catch (\SoapFault $e) {
        // Handle the SOAP error
        return ['error' => 'Error fetching exchange rates: ' . $e->getMessage()];
    }
}

switch ($route) {
    case '':
        // Default page or home
        echo "Welcome to the Home page!";
        break;

    case 'daily-exchange-rate':
        // Handle the form submission and get the currency pair and date
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currencyPair = isset($_POST['currencyPair']) ? strtoupper($_POST['currencyPair']) : '';
            $date = isset($_POST['date']) ? $_POST['date'] : '';

            if ($currencyPair && $date) {
                $result = showDailyExchangeRate($currencyPair, $date);

                // Check if there is an error
                if (isset($result['error'])) {
                    $errors[] = $result['error'];
                } else {
                    // Prepare data for the view
                    $currencyPair = $result['pair'];
                    $rates = $result['rates'];
                }
            } else {
                $errors[] = 'Please enter both currency pair and date.';
            }
        }

        // Include the view to display results or error message
        include 'views/exchange_rate.php';
        break;

    case 'monthly-exchange-rate':
        // Handle the form submission for monthly exchange rates
        // Implement the logic for monthly rate lookup here
        break;

    default:
        // Handle 404
        echo "404 Page Not Found";
        break;
}
?>
