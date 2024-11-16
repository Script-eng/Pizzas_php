<?php

namespace App\Controllers;

use SoapClient;
use Exception;

class MNBController
{
    // Show Daily Exchange Rate
    public function showDailyExchangeRate()
    {
        try {
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

            return $this->render('exchange_rate', [
                'rates' => $rates,
                'date' => (string)$dayData->attributes()->date
            ]);
        } catch (Exception $e) {
            return $this->render('exchange_rate', ['error' => 'Error fetching exchange rates: ' . $e->getMessage()]);
        }
    }

    // Fetch Exchange Rate by Specific Date
    public function getExchangeRateByDate($currencyPair, $date)
    {
        try {
            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

            // Split the currency pair into individual currencies
            list($baseCurrency, $targetCurrency) = explode('-', $currencyPair);

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

            return $this->render('exchange_rate', [
                'rates' => $rates,
                'date' => $date,
                'currencyPair' => $currencyPair
            ]);
        } catch (Exception $e) {
            return $this->render('exchange_rate', ['error' => 'Error fetching exchange rates: ' . $e->getMessage()]);
        }
    }

    // Show Monthly Exchange Rate with Chart
    public function showMonthlyExchangeRate($currencyPair, $month)
    {
        try {
            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

            // Split the currency pair into individual currencies
            list($baseCurrency, $targetCurrency) = explode('-', $currencyPair);

            // Calculate the start and end date of the month
            $startDate = $month . '-01';
            $endDate = date("Y-m-t", strtotime($startDate));  // Get the last day of the month

            // Call the GetExchangeRates method with the given date range and currency pair
            $response = $client->GetExchangeRates([
                'startDate' => $startDate,
                'endDate' => $endDate,
                'currencyNames' => "{$baseCurrency},{$targetCurrency}",
            ])->GetExchangeRatesResult;

            // Convert XML response to an associative array
            $exchangeRates = simplexml_load_string($response);

            // Prepare an array to store rates for the chart
            $rates = [];
            $dates = [];

            foreach ($exchangeRates->Day as $day) {
                $date = (string)$day['date'];
                $rates[] = [
                    'date' => $date,
                    'rate' => (float)$day->Rate,
                ];
                $dates[] = $date;
            }

            return $this->render('monthly_exchange_rate', [
                'rates' => $rates,
                'dates' => $dates,
                'currencyPair' => $currencyPair,
                'startDate' => $startDate,  // Add startDate to the view
            ]);
        } catch (Exception $e) {
            return $this->render('monthly_exchange_rate', ['error' => 'Error fetching exchange rates: ' . $e->getMessage()]);
        }
    }

    // Helper method to render views
    protected function render($view, $data = [])
    {
        extract($data);
        include "views/{$view}.php";
    }
}
