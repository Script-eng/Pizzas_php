<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exchange Rates</title>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Exchange Rate Lookup</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php echo $errors[0]; ?>
        </div>
    <?php endif; ?>

    
    <form method="POST" action="index.php?route=daily-exchange-rate" class="mb-4">
        <div class="form-row align-items-center">
            <div class="col-md-5 mb-3">
                <label for="currencyPair">Currency Pair (e.g., EUR-HUF):</label>
                <input type="text" class="form-control" name="currencyPair" id="currencyPair" placeholder="e.g., EUR-HUF" required>
            </div>
            <div class="col-md-5 mb-3">
                <label for="date">Date:</label>
                <input type="date" class="form-control" name="date" id="date" required>
            </div>
            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-primary btn-block mt-4">Get Exchange Rate</button>
            </div>
        </div>
    </form>

    <h2 class="text-center">
        Exchange Rate for <?php echo isset($currencyPair) ? htmlspecialchars($currencyPair) : ''; ?> on 
        <?php echo isset($date) ? htmlspecialchars($date) : ''; ?>
    </h2>

    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead class="thead-dark">
            <tr>
                <th>Currency</th>
                <th>Rate</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($rates)): ?>
                <?php foreach ($rates as $currency => $rate): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($currency); ?></td>
                        <td><?php echo htmlspecialchars($rate); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">No rates available</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
