<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Exchange Rates</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Monthly Exchange Rates</h1>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <!-- Monthly Rate Lookup Form -->
    <form method="POST" action="index.php?route=monthly-exchange-rate" class="mb-4">
        <div class="form-row align-items-center">
            <div class="col-md-5 mb-3">
                <label for="currencyPair">Currency Pair (e.g., EUR-HUF):</label>
                <input type="text" class="form-control" name="currencyPair" id="currencyPair" value="<?= htmlspecialchars($currencyPair); ?>" required>
            </div>
            <div class="col-md-5 mb-3">
                <label for="startDate">Start Date:</label>
                <input type="date" class="form-control" name="startDate" id="startDate" value="<?= htmlspecialchars($startDate); ?>" required>
            </div>
            <div class="col-md-5 mb-3">
                <label for="endDate">End Date:</label>
                <input type="date" class="form-control" name="endDate" id="endDate" value="<?= htmlspecialchars($endDate); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-primary btn-block mt-4">Get Monthly Rates</button>
            </div>
        </div>
    </form>

    <?php if (!empty($rates)) : ?>
        <h2 class="text-center">Exchange Rates for <?= htmlspecialchars($currencyPair); ?> from <?= htmlspecialchars($startDate); ?> to <?= htmlspecialchars($endDate); ?></h2>

        <div class="row">
            <div class="col-md-12">
                <canvas id="exchangeRateChart"></canvas>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Prepare data for the chart
        const dates = <?= json_encode($dates); ?>;
        const rates = <?= json_encode($ratesList); ?>;

        if (dates.length && rates.length) {
            // Chart.js configuration
            var ctx = document.getElementById('exchangeRateChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Exchange Rate for <?= htmlspecialchars($currencyPair); ?>',
                        data: rates,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Exchange Rate'
                            },
                            beginAtZero: false,
                        }
                    }
                }
            });
        }
    </script>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
