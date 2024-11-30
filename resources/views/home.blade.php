<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria Delights</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <!-- Navigation -->
    <x-navbar />

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden lg:mb-4">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-transparent sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left lg:w-[80%]">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Delicious Pizza</span>
                            <span class="block text-red-600 xl:inline">Delivered Hot</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Experience the authentic taste of Italy with our handcrafted pizzas made from the finest ingredients.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('pizzas.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10">
                                    Let's Order
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-12 lg:w-1/2 lg:py-20 lg:px-12">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full rounded-xl" src="{{URL::asset('/images/pizzeria-hero.webp')}}" alt="Pizza">
        </div>
    </div>

    <!-- About us -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Authentic Italian Cuisine, Made with Passion
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    At our pizzeria, we believe in the art of crafting pizzas that bring people together. Our secret?
                    Simple, high-quality ingredients, traditional recipes, and a whole lot of love.
                </p>
            </div>

            <div class="my-10 lg:my-20">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-red-600 text-white">
                                <!-- Hero icon or FontAwesome icon -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Family Tradition</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Our recipes have been passed down through generations, bringing the authentic taste of Italy right to your table.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-red-600 text-white">
                                <!-- Hero icon or FontAwesome icon -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Fresh Ingredients</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            We use only the freshest, locally-sourced ingredients to ensure the highest quality in every bite.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-red-600 text-white">
                                <!-- Hero icon or FontAwesome icon -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Craftsmanship</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Every pizza is crafted by hand, ensuring the perfect balance of flavors and textures in every slice.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-white py-20 mb-6 lg:mb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Our Commitment to Quality & Service
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    We don’t just make pizzas. We create unforgettable experiences with every meal, ensuring that you get the best quality food, every time.
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Unmatched Quality</h3>
                        <p class="mt-2 text-base text-gray-500">
                            We use premium, fresh ingredients, sourced locally whenever possible, to ensure each pizza is crafted to perfection.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Fast Delivery</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Enjoy hot and fresh pizzas delivered to your doorstep in no time, thanks to our efficient delivery team.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Friendly Service</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Our team is dedicated to providing exceptional customer service, making sure every order exceeds your expectations.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Customizable Pizzas</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Choose from a variety of toppings and crust options to create your perfect pizza, just the way you like it.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Affordable Prices</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Enjoy gourmet pizzas without breaking the bank. We offer high-quality food at reasonable prices.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-600 text-white mx-auto">
                            <!-- FontAwesome or Hero icon -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3-.895 3-2 0-1.105-1.344-2-3-2S9 4.895 9 6c0 1.105 1.344 2 3 2zm0 4a4 4 0 00-4 4h8a4 4 0 00-4-4zm0-6c3.315 0 6-2.236 6-5S15.315 0 12 0 6 2.236 6 5s2.685 5 6 5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl leading-6 font-medium text-gray-900">Sustainability</h3>
                        <p class="mt-2 text-base text-gray-500">
                            We’re committed to sustainability by using eco-friendly packaging and sourcing responsibly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="bg-red-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>© 2024 Royal Pizza. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>