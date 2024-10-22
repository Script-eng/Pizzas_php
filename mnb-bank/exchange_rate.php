<?php
// exchange_rate.php

include('soap_client.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $currencyPair = $_POST['currencyPair'] ?? '';
    $month = $_POST['month'] ?? '';

    if (!empty($currencyPair) && !empty($month)) {
        // Convert the month input (e.g., "2024-06") into start and end dates
        $startDate = $month . '-01'; // First day of the month
        $endDate = date("Y-m-t", strtotime($startDate)); // Last day of the month

        // Fetch exchange rates for the date range
        $rates = getMonthlyExchangeRates($currencyPair, $startDate, $endDate);

        // Debug: Print the exchange rates response
        echo "<pre>";
        print_r($rates);
        echo "</pre>";

        // Prepare data for Chart.js
        $labels = [];
        $data = [];

        foreach ($rates as $rate) {
            $labels[] = $rate['date'];
            $data[] = $rate['rate'];
        }
    } else {
        echo "Please select a currency pair and a month.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Exchange Rates</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Fetch Exchange Rate</h1>
    <form action="exchange_rate.php" method="POST">
        <label for="currencyPair">Currency Pair (e.g., EUR-HUF):</label>
        <select id="currencyPair" name="currencyPair">
            <option value="EUR-HUF">EUR-HUF</option>
            <option value="USD-HUF">USD-HUF</option>
            <option value="GBP-HUF">GBP-HUF</option>
        </select>

        <br><br>
        <label for="month">Select Month:</label>
        <input type="month" id="month" name="month" required>

        <br><br>
        <button type="submit">Get Exchange Rates</button>
    </form>

    <?php if (!empty($rates)) : ?>
        <h2>Exchange Rates for <?php echo $currencyPair; ?> in <?php echo $month; ?></h2>

        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rates as $rate) : ?>
                    <tr>
                        <td><?php echo $rate['date']; ?></td>
                        <td><?php echo $rate['rate']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="chart-container" style="width: 75%; height: 400px;">
            <canvas id="exchangeRateChart"></canvas>
        </div>

        <script>
            var labels = <?php echo json_encode($labels); ?>;
            var data = <?php echo json_encode($data); ?>;
            renderChart(labels, data);
        </script>
    <?php endif; ?>

    <script>
        function renderChart(labels, data) {
            var ctx = document.getElementById('exchangeRateChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Exchange Rate',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
