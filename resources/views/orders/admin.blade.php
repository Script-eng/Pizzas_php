<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Pizzeria Delights</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <x-navbar />

    <!-- Dashboard Content -->
    <div class="container mx-auto py-12 px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-light text-gray-800">Order Management</h1>
            <div class="flex space-x-4">
                <select id="statusFilter" class="rounded-lg border-gray-200 text-gray-700 text-sm focus:ring-blue-500">
                    <option value="">All Orders</option>
                    <option value="pending">Pending</option>
                    <option value="preparing">Preparing</option>
                    <option value="dispatched">Dispatched</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

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
            <p class="text-lg">No orders found.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($orders as $order)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-medium text-gray-800">Order #{{ $order->id }}</h2>
                    <span class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-gray-600">Customer: <span class="text-gray-800">{{ $order->user->name }}</span></p>
                    </div>
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
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-900 font-semibold">Total: <span class="text-xl">€{{ number_format($order->total_price, 0, '.', ',') }}</span></p>
                        <form action="{{ route('orders.update', $order) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            @method('PATCH')
                            <select name="status"
                                class="rounded-lg border-gray-200 text-sm focus:ring-blue-500
        {{ $order->status->value === 'pending' ? 'text-yellow-600' : '' }}
        {{ $order->status->value === 'preparing' || $order->status->value === 'dispatched' ? 'text-blue-600' : '' }}
        {{ $order->status->value === 'delivered' ? 'text-green-600' : '' }}
        {{ $order->status->value === 'cancelled' ? 'text-red-600' : '' }}">
                                <option value="pending"
                                    {{ $order->status->value === 'pending' ? 'selected="selected"' : '' }}>
                                    Pending
                                </option>
                                <option value="preparing"
                                    {{ $order->status->value === 'preparing' ? 'selected="selected"' : '' }}>
                                    Preparing
                                </option>
                                <option value="dispatched"
                                    {{ $order->status->value === 'dispatched' ? 'selected="selected"' : '' }}>
                                    Dispatched
                                </option>
                                <option value="delivered"
                                    {{ $order->status->value === 'delivered' ? 'selected="selected"' : '' }}>
                                    Delivered
                                </option>
                                <option value="cancelled"
                                    {{ $order->status->value === 'cancelled' ? 'selected="selected"' : '' }}>
                                    Cancelled
                                </option>
                            </select>

                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            window.location.href = `{{ route('admin') }}${status ? `?status=${status}` : ''}`;
        });

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        const statusParam = getQueryParam('status');
        if (statusParam) {
            const statusFilter = document.getElementById('statusFilter');
            statusFilter.value = statusParam;
        }
    </script>
</body>

</html>