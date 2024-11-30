<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the route from the query string
$route = isset($_GET['route']) ? $_GET['route'] : '';

require_once 'services/MNBSoapservice.php'; 

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

// Function to fetch exchange rates for a specific date
function getExchangeRateByDate($currencyPair, $date) {
    try {
        // Create a new SOAP client
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

        // Split the currency pair into individual currencies
        list($baseCurrency, $targetCurrency) = explode('-', strtoupper($currencyPair));

        // Call the GetExchangeRates method with the given date and currency pair
        $response = $client->GetExchangeRates([
            'startDate' => $date,
            'endDate' => $date,
            'currencyNames' => "{$baseCurrency},{$targetCurrency}",
        ])->GetExchangeRatesResult;

        // Convert XML response to an associative array
        $exchangeRates = (array)simplexml_load_string($response);

        // Prepare a variable to store the rates
        $rates = [];
        $dayData = $exchangeRates['Day'] ?? null;

        if ($dayData) {
            foreach ($dayData->Rate as $rate) {
                $currencyCode = (string)$rate['curr'];
                $currencyValue = (string)$rate;

                // Store in the rates array
                $rates[$currencyCode] = $currencyValue;
            }
        }

        return ['pair' => $currencyPair, 'rates' => $rates, 'date' => $date];
    } catch (\SoapFault $e) {
        // Handle the SOAP error
        return ['error' => 'Error fetching exchange rates: ' . $e->getMessage()];
    }
}
function getMonthlyExchangeRates($currency, $startDate, $endDate){
        $xmlResponse = $this->client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency,
        ])->GetExchangeRatesResult;

        return (array)simplexml_load_string($xmlResponse);
    }
$errors = [];  // Initialize errors array

switch ($route) {
    case 'pizza':
        include 'controllers/pizza_controller.php';
        break;
    case 'category':
        include 'controllers/category_controller.php';
        break;
    case 'order':
        include 'controllers/order_controller.php';
        break;
    case '':
        // Default page or home
        echo "Welcome to the Home page!";
        break;
    case 'rest_api':    
        include 'rest_api.php';
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
        require_once 'services/MNBSoapservice.php';

        $service = new MNBSoapservice();  // Instantiate the service
        $rates = [];
        $dates = [];
        $ratesList = [];
        $currencyPair = 'EUR-HUF'; // Default currency pair
        $startDate = '';
        $endDate = '';
        $error = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currencyPair = isset($_POST['currencyPair']) ? strtoupper($_POST['currencyPair']) : 'EUR-HUF';
            $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
            $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';

            // Validate input
            if ($currencyPair && $startDate && $endDate) {
                try {
                    // Fetch exchange rates using the service
                    $rates = $service->getMonthlyExchangeRates($currencyPair, $startDate, $endDate);

                    // Prepare data for Chart.js
                    foreach ($rates as $rateData) {
                        $dates[] = $rateData['date'];
                        $ratesList[] = $rateData['rate'];
                    }
                } catch (Exception $e) {
                    $error = 'Error fetching rates: ' . $e->getMessage();
                }
            } else {
                $error = 'Please enter currency pair, start date, and end date.';
            }
        }

        // Include the view file
        include 'views/monthly_exchange_rate.php';
        break;

    case 'home':
    default:
        // Default home page
        echo "<h1>Welcome to the Exchange Rate App</h1>";
        echo "<p><a href='index.php?route=daily-exchange-rate'>Get Daily Exchange Rate</a></p>";
        echo "<p><a href='index.php?route=monthly-exchange-rate'>Get Monthly Exchange Rate</a></p>";
        echo "<p><a href='index.php?route=rest_api'>Database Data</a></p>";
        echo "<p><a href='index.php?route=pizza'>Manage Pizzas</a></p>";
        echo "<p><a href='index.php?route=category'>Manage Categories</a></p>";
        echo "<p><a href='index.php?route=order'>Manage Orders</a></p>";
        
        break;

        // Handle 404
        echo "404 Page Not Found";
        break;
}
?>
