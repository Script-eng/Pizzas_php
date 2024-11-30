<?php

namespace App\Services;

use SoapClient;
use Carbon\Carbon;

class MnbService
{
    private $client;
    private $wsdl = 'http://www.mnb.hu/arfolyamok.asmx?wsdl';

    public function __construct()
    {
        $this->client = new SoapClient($this->wsdl);
    }

    public function getRateForDate($currencyPair, $date)
    {
        $fromCurrency = substr($currencyPair, 0, 3);
        $toCurrency = substr($currencyPair, 4, 3);

        $date = Carbon::parse($date)->format('Y-m-d');

        $result = $this->client->GetExchangeRates([
            'startDate' => $date,
            'endDate' => $date,
            'currencyNames' => $fromCurrency
        ]);

        // Parse the XML response
        $xml = simplexml_load_string($result->GetExchangeRatesResult);
        $rate = (float)$xml->Day->Rate;

        if ($toCurrency === 'HUF') {
            return $rate;
        } else {
            // Convert to requested currency pair
            $secondRate = $this->getRateForDate($toCurrency . '-HUF', $date);
            return $rate / $secondRate;
        }
    }

    public function getMonthlyRates($currencyPair, $month, $year)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $fromCurrency = substr($currencyPair, 0, 3);
        $toCurrency = substr($currencyPair, 4, 3);

        $result = $this->client->GetExchangeRates([
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'currencyNames' => $fromCurrency
        ]);

        $xml = simplexml_load_string($result->GetExchangeRatesResult);

        $rates = [];
        foreach ($xml->Day as $day) {
            $date = (string)$day['date'];
            $rate = (float)$day->Rate;

            if ($toCurrency === 'HUF') {
                $rates[$date] = $rate;
            } else {
                $secondRate = $this->getRateForDate($toCurrency . '-HUF', $date);
                $rates[$date] = $rate / $secondRate;
            }
        }

        return $rates;
    }
}
