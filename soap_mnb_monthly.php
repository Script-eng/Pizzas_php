<pre>
<?php

echo "we are here";
// Soap Client initialization
$client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

// Function to get exchange rates for a given currency pair in a month
function getExchangeRatesForMonth($currencyPair, $month, $year) {
    try {
        $response = $client->GetCurrentExchangeRates();
        $rates = simplexml_load_string($response->GetCurrentExchangeRatesResult);
        $ratesArray = (array)$rates;

        $data = [];
        foreach ($ratesArray['Day'] as $day) {
            $dayDate = $day['date'];
            $dayMonth = date('m', strtotime($dayDate));
            $dayYear = date('Y', strtotime($dayDate));

            if ($dayMonth == $month && $dayYear == $year) {
                foreach ($day['rates'] as $rate) {
                    if ($rate['currency'] == $currencyPair) {
                        $data[] = ['date' => $dayDate, 'rate' => $rate['rate']];
                    }
                }
            }
        }

        return $data;
    } catch (SoapFault $e) {
        return "Error: " . $e->getMessage();
    }
}

// Example of how to call the function
$currencyPair = 'EURHUF'; // Example: EUR-HUF
$month = '11'; // November
$year = '2024'; // Year 2024
$exchangeRates = getExchangeRatesForMonth($currencyPair, $month, $year);

echo "<h3>Exchange rates for $currencyPair in $month/$year:</h3>";

if (empty($exchangeRates)) {
    echo "No data found for this currency pair and month.";
} else {
    echo "<table border='1'><tr><th>Date</th><th>Rate</th></tr>";
    foreach ($exchangeRates as $rate) {
        echo "<tr><td>" . htmlspecialchars($rate['date']) . "</td><td>" . htmlspecialchars($rate['rate']) . "</td></tr>";
    }
    echo "</table>";

    // Prepare data for Chart.js
    $labels = array_column($exchangeRates, 'date');
    $rates = array_column($exchangeRates, 'rate');
    ?>
    <canvas id="exchangeRateChart" width="400" height="200"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('exchangeRateChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Exchange Rate for <?php echo $currencyPair; ?>',
                    data: <?php echo json_encode($rates); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Rate'
                        }
                    }
                }
            }
        });
    </script>
    <?php
}
?>
</pre>
