<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Pizzeria Delights</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <x-navbar />

    <!-- Dashboard Content -->
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-4xl font-light text-center mb-8 text-gray-800">Your Orders</h1>

        @if (session('success'))
        <div class="bg-green-50 text-green-700 px-6 py-3 rounded-lg mb-8 text-center shadow-sm border border-green-200 max-w-2xl mx-auto">
            {{ session('success') }}
        </div>
        @endif

        @if ($orders->isEmpty())
        <div class="text-center text-gray-500 bg-white rounded-xl shadow-sm p-12 max-w-md mx-auto border border-gray-100">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="text-lg">You haven't placed any orders yet.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($orders as $order)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h2 class="text-xl font-medium text-gray-800">Order #{{ $order->id }}</h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600">Pizza: <span class="text-gray-800">{{ $order->pizza->name }}</span></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                        <p class="text-gray-600">Quantity: <span class="text-gray-800">{{ $order->quantity }}</span></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-gray-600 truncate">Address: <span class="text-gray-800">{{ $order->address }}</span></p>
                    </div>
                    @if($order->notes)
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-600">Notes: <span class="text-gray-800">{{ $order->notes }}</span></p>
                    </div>
                    @endif
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600">Status:
                            @php
                            if ($order->status->value === 'pending') {
                            $statusClasses = 'bg-yellow-100 text-yellow-800';
                            } elseif ($order->status->value === 'preparing') {
                            $statusClasses = 'bg-blue-100 text-blue-800';
                            } elseif ($order->status->value === 'dispatched') {
                            $statusClasses = 'bg-purple-100 text-purple-800';
                            } elseif ($order->status->value === 'delivered') {
                            $statusClasses = 'bg-green-100 text-green-800';
                            } else {
                            $statusClasses = 'bg-red-100 text-red-800';
                            }
                            @endphp

                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $statusClasses }}">
                                {{ $order->status }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <p class="text-gray-900 font-semibold">Total: <span class="text-xl">€{{ number_format($order->total_price, 0, '.', ',') }}</span></p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</body>

</html>