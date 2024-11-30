<?php
class MNBSoapService
{
    protected $client;

    public function __construct()
    {
        // SOAP client initialization
        $this->client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    }

    public function getCurrentExchangeRates()
    {
        // Fetch current exchange rates
        $response = $this->client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult;
        return (array)simplexml_load_string($response);
    }

    public function getExchangeRateForDate($currency, $date)
    {
        // Fetch exchange rates for a specific date
        $xmlResponse = $this->client->GetExchangeRates([
            'startDate' => $date,
            'endDate' => $date,
            'currencyNames' => $currency,
        ])->GetExchangeRatesResult;

        return (array)simplexml_load_string($xmlResponse);
    }

    public function getMonthlyExchangeRates($currency, $startDate, $endDate)
    {
        // Fetch exchange rates for a specific date range
        $xmlResponse = $this->client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency,
        ])->GetExchangeRatesResult;

        return (array)simplexml_load_string($xmlResponse);
    }
}
?>