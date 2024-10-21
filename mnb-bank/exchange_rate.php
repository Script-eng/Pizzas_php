<?php
// exchange_rate.php

include('soap_client.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $currencyPair = $_POST['currencyPair'];
    $date = $_POST['date'];

    // Fetch exchange rate
    $exchangeRate = getExchangeRate($currencyPair, $date);

    // Display the result
    if ($exchangeRate) {
        echo "<p>Exchange rate for $currencyPair on $date: $exchangeRate</p>";
    } else {
        echo "<p>Failed to retrieve exchange rate for $currencyPair on $date.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Exchange Rate</title>
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
        <label for="date">Date (YYYY-MM-DD):</label>
        <input type="date" id="date" name="date" required>

        <br><br>
        <button type="submit">Get Exchange Rate</button>
    </form>
</body>
</html>
