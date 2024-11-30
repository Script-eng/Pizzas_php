<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisanal Pizzas | Our Menu</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-stone-100 to-stone-200 min-h-screen">
    <!-- Navigation -->
    <x-navbar />

    <!-- Hero Section -->
    <div class="relative h-64 md:h-96 overflow-hidden">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Our Artisanal Pizzas</h1>
            <p class="text-lg md:text-xl text-stone-200 max-w-2xl px-4">Crafted with passion, served with excellence</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-7xl">
        <!-- Category Navigation -->
        <nav class="mb-16">
            <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                <a href="{{ route('pizzas.index', []) }}"
                    class="px-6 py-3 {{ !$category ? 'bg-amber-700 text-white' : 'bg-white/80 text-stone-700' }}
                  hover:bg-amber-600 hover:text-white transition-all duration-300
                  backdrop-blur-sm rounded-md text-sm md:text-base font-medium">
                    All Selections
                </a>
                @foreach($categories as $cat)
                <a href="{{ url('/pizzas/' . $cat->cname) }}"
                    class="px-6 py-3 {{ $category === $cat->cname ? 'bg-amber-700 text-white' : 'bg-white/80 text-stone-700' }}
                      hover:bg-amber-600 hover:text-white transition-all duration-300
                      backdrop-blur-sm rounded-md text-sm md:text-base font-medium">
                    {{ ucfirst($cat->cname) }}
                </a>
                @endforeach
            </div>
        </nav>


        <!-- Pizza Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            @foreach($pizzas as $pizza)
            <article class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300">
                <!-- Pizza Image Container -->
                <div class="relative aspect-square overflow-hidden rounded-t-2xl">
                    <img src="{{ URL::asset('images/' . Str::slug($pizza->category_name) . '.webp') }}"
                        alt="{{ $pizza->pname }}"
                        class="h-full w-full object-cover transition-transform duration-500 hover:scale-110">

                    <!-- Vegetarian Badge -->
                    @if($pizza->vegetarian)
                    <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-emerald-100/95 backdrop-blur-sm px-3 py-1.5 text-xs font-medium text-emerald-700 shadow-sm">
                        <i class="fas fa-leaf"></i>
                        Vegetarian
                    </span>
                    @endif
                </div>

                <!-- Content Container -->
                <div class="p-5 space-y-4">
                    <!-- Header Section -->
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 hover:text-amber-600 transition-colors duration-200">
                            {{ $pizza->pname }}
                        </h3>
                        <span class="px-2.5 py-1 rounded-full bg-stone-100 text-xs font-medium text-stone-600 capitalize">
                            {{ $pizza->category->cname }}
                        </span>
                    </div>

                    <!-- Price and Order Section -->
                    <div class="flex items-center justify-between pt-2">
                        <p class="text-xl font-bold text-amber-600">
                            €{{ number_format($pizza->category->price, 0, '.', ',') }}
                        </p>

                        <div x-data="{ open: false, quantity: 1 }" x-cloak>
                            <!-- Order Button -->
                            <button @click="open = true"
                                class="relative inline-flex items-center px-6 py-2.5 rounded-lg bg-amber-500 text-white font-semibold
                   hover:bg-amber-600 active:bg-amber-700
                   transition-all duration-200
                   focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2
                   shadow-sm hover:shadow-md z-10">
                                Order Now
                            </button>

                            <!-- Modal -->
                            <div x-show="open"
                                class="fixed inset-0 z-50 overflow-y-auto"
                                role="dialog"
                                aria-modal="true">
                                <!-- Overlay -->
                                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="open = false"></div>

                                <!-- Modal Content -->
                                <div class="relative min-h-screen flex items-center justify-center p-4">
                                    <div class="relative bg-white rounded-2xl max-w-md w-full p-6 overflow-hidden shadow-xl">
                                        <div class="absolute right-4 top-4">
                                            <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Close</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                                            @csrf
                                            <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">

                                            <div class="mt-4">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h2 class="text-xl font-semibold text-gray-900">{{ $pizza->pname }}</h2><span class="px-2.5 py-1 rounded-full bg-stone-200 text-xs font-medium text-stone-700 capitalize">
                                                        {{ $pizza->category->cname }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 mb-4">€{{ number_format($pizza->category->price, 0, '.', ',') }}</p>
                                            </div>

                                            <div>
                                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                                <div class="mt-1 flex items-center space-x-3">
                                                    <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="p-2 rounded-md bg-gray-100 hover:bg-gray-200">-</button>
                                                    <input type="number"
                                                        name="quantity"
                                                        x-model="quantity"
                                                        min="1"
                                                        class="block w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                                    <button type="button" @click="quantity++" class="p-2 rounded-md bg-gray-100 hover:bg-gray-200">+</button>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                                <textarea name="address"
                                                    rows="3"
                                                    required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                                            </div>

                                            <div>
                                                <label for="notes" class="block text-sm font-medium text-gray-700">Special Instructions (Optional)</label>
                                                <textarea name="notes"
                                                    rows="2"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                                            </div>

                                            <div class="flex items-center justify-end space-x-3 pt-4">
                                                <button type="button"
                                                    @click="open = false"
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                                    Place Order
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            @endforeach

        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-24 bg-stone-900 text-stone-400 py-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">Our pizzas are crafted with locally sourced ingredients and baked in traditional wood-fired ovens.</p>
        </div>
    </footer>
</body>

</html>