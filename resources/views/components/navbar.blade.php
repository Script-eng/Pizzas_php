<nav class="bg-red-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img class="h-9 w-auto" src="{{URL::asset('/images/pizzeria-logo.svg')}}" alt="Pizzeria Logo">
                </a>
            </div>

            <!-- User Menu -->
            <div class="flex items-center">
                @foreach($featuredItems as $item)
                @if($item->name === 'Home')
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                    Home
                </a>
                @elseif($item->name === 'Menu')
                <!-- Dropdown for Categories under Menu -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-white transition-colors duration-200 hover:text-gray-200 px-4 py-2 text-sm font-medium rounded-lg">
                        Menu
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute right-0 z-50 invisible opacity-0 transform transition-all duration-200 origin-top-right scale-95
                group-hover:visible group-hover:opacity-100 group-hover:scale-100
                w-48 mt-2 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white">
                        <span class="block px-4 py-2.5 text-sm text-gray-700 font-semibold border-b border-gray-200">
                            Categories
                        </span>
                        <a href="{{ route('pizzas.index') }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 transition-colors duration-150
                  first:rounded-t-lg
                  hover:bg-gray-100 hover:text-gray-900">
                            All selections
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('pizzas.index', $category->cname) }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 transition-colors duration-150
                  last:rounded-b-lg
                  hover:bg-gray-100 hover:text-gray-900">
                            {{ ucfirst($category->cname) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- Other Featured Items -->
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                    {{ ucfirst($item->name) }}
                </a>
                @endif
                @endforeach

                @guest
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                    Register
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                    My Orders
                </a>
                <div class="relative group">
                    <button class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="absolute right-0 z-50 hidden group-hover:block w-48 rounded-md shadow-lg py-1 bg-white">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            My Profile
                        </a>
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Admin Panel
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                @endguest
            </div>


        </div>
    </div>
</nav>