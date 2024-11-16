<pre>

<?php
try {
$client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
echo "<br>GetCurrentExchangeRates()<br>";
$array = (array)simplexml_load_string($client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult);
echo $array['Day']['date']."<br>";
print_r($array);
echo "<br>GetInfo()<br>";
$array = (array)simplexml_load_string($client->GetInfo()->GetInfoResult);
print_r($array);
echo "<br>GetCurrencies()<br>";
$array = (array)simplexml_load_string($client->GetCurrencies()->GetCurrenciesResult);
print_r($array);
echo "<br>GetDateInterval()<br>";
$array = (array)simplexml_load_string($client->GetDateInterval()->GetDateIntervalResult);
print_r($array);
} catch (SoapFault $e) {
var_dump($e);
}
?>
</pre>