<!-- resources/views/exchange-rates/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNB Exchange Rates</title>
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>

<body class="bg-gray-100">
    <div id="app" class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-semibold text-gray-800">Hungarian National Bank SOAP Data Service</span>
                    </div>

                </div>
            </div>
        </nav>
        <div class="container mx-auto px-4 py-8 mt-8">
            <h1 class="text-3xl font-bold mb-8">MNB Exchange Rates</h1>

            <!-- Daily Rate Query -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Daily Exchange Rate</h2>
                <form id="dailyRateForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Currency Pair</label>
                            <input type="text" name="currency_pair" value="EUR/HUF" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 uppercase"
                                oninput="this.value = this.value.toUpperCase();" placeholder="e.g., EUR/HUF">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="flex items-end justify-end w-full">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Get Rate
                            </button>
                        </div>
                    </div>
                </form>
                <div id="dailyResult" class="mt-4 text-lg font-semibold hidden"></div>
                <div id="dailyLoading" class="mt-4 text-lg font-semibold hidden">Loading...</div>
            </div>

            <!-- Monthly Rates Query -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Monthly Exchange Rates</h2>
                <form id="monthlyRateForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Currency Pair</label>
                            <input type="text" name="currency_pair" value="EUR/HUF" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 uppercase"
                                oninput="this.value = this.value.toUpperCase();" placeholder="e.g., EUR/HUF">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Month</label>
                            <select name="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Year</label>
                            <select name="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @for($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex items-end justify-end w-full">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Get Rates
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Monthly rates table -->
                <div class="mt-6 overflow-x-auto">
                    <table id="monthlyRatesTable" class="min-w-full divide-y divide-gray-200 hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>

                <div id="monthlyLoading" class="mt-12 text-lg font-semibold text-center w-full hidden">Loading...</div>

                <!-- Chart -->
                <div class="mt-6">
                    <canvas id="ratesChart" class="w-full h-64"></canvas>
                </div>
            </div>
        </div>

        <script>
            let chart = null;

            async function fetchDailyRate(currencyPair, date) {
                const resultDiv = document.getElementById('dailyResult');
                const loadingIndicator = document.getElementById('dailyLoading');

                resultDiv.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');

                try {
                    const response = await fetch(`/api/mnb/daily-rate?currency_pair=${currencyPair}&date=${date}`);
                    const data = await response.json();

                    resultDiv.textContent = `Exchange rate: ${data.rate.toFixed(2)}`;
                    resultDiv.classList.remove('hidden');
                } catch (error) {
                    console.error('Error fetching daily rate:', error);
                    resultDiv.textContent = 'Error fetching daily rate';
                    resultDiv.classList.remove('hidden');
                } finally {
                    loadingIndicator.classList.add('hidden');
                }
            }


            async function fetchMonthlyRates(currencyPair, month, year) {
                const tbody = document.querySelector('#monthlyRatesTable tbody');
                const table = document.getElementById('monthlyRatesTable');
                const loadingIndicator = document.getElementById('monthlyLoading');
                table.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');

                tbody.innerHTML = '';

                try {
                    const response = await fetch(`/api/mnb/monthly-rates?currency_pair=${currencyPair}&month=${month}&year=${year}`);
                    const data = await response.json();

                    Object.entries(data.rates).forEach(([date, rate]) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">${date}</td>
                <td class="px-6 py-4 whitespace-nowrap">${rate}</td>
            `;
                        tbody.appendChild(row);
                    });
                    table.classList.remove('hidden');

                    // Update chart
                    if (chart) {
                        chart.destroy();
                    }

                    const ctx = document.getElementById('ratesChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(data.rates),
                            datasets: [{
                                label: 'Exchange Rate',
                                data: Object.values(data.rates),
                                borderColor: 'rgb(59, 130, 246)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Exchange Rates Over Time'
                                }
                            }
                        }
                    });

                } catch (error) {
                    console.error('Error fetching monthly rates:', error);
                    tbody.innerHTML = '<tr><td colspan="2" class="px-6 py-4 text-center text-red-500">Error fetching monthly rates</td></tr>';
                    table.classList.remove('hidden');
                } finally {
                    loadingIndicator.classList.add('hidden');
                }

            }

            document.getElementById('dailyRateForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                await fetchDailyRate(formData.get('currency_pair'), formData.get('date'));
            });

            document.getElementById('monthlyRateForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                await fetchMonthlyRates(
                    formData.get('currency_pair'),
                    formData.get('month'),
                    formData.get('year')
                );
            });


            document.addEventListener('DOMContentLoaded', async () => {
                const today = new Date();
                const dateInput = document.querySelector('input[name="date"]');
                dateInput.value = today.toISOString().split('T')[0];

                const monthSelect = document.querySelector('select[name="month"]');
                monthSelect.value = today.getMonth() + 1;

                const yearSelect = document.querySelector('select[name="year"]');
                yearSelect.value = today.getFullYear();

                await fetchDailyRate('EUR-HUF', dateInput.value);
                await fetchMonthlyRates('EUR-HUF', today.getMonth() + 1, today.getFullYear());
            });
        </script>
</body>

</html>