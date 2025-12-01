<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link href="{{ route('entities.index', ['type' => 'client']) }}" :active="request()->routeIs('entities.index') && request('type') === 'client'">
                        Clients
                    </x-nav-link>

                    <x-nav-link href="{{ route('entities.index', ['type' => 'supplier']) }}" :active="request()->routeIs('entities.index') && request('type') === 'supplier'">
                        Suppliers
                    </x-nav-link>

                    <x-nav-link href="{{ route('contacts.index') }}" :active="request()->routeIs('contacts.index')">
                        Contacts
                    </x-nav-link>

                    <x-nav-link href="{{ route('items.index') }}" :active="request()->routeIs('items.*')">
                        Items
                    </x-nav-link>
                    <x-nav-link href="{{ route('proposals.index') }}" :active="request()->routeIs('proposals.*')">
                        Business Proposals
                    </x-nav-link>
                    <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')">
                        Orders
                    </x-nav-link>

                    <x-nav-link href="{{ route('calendar.index') }}" :active="request()->routeIs('calendar.*')">
                        Calendar
                    </x-nav-link>
                 
                </div>
            </div>

            <!-- User & Teams dropdown (keep Jetstream default) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <!-- Teams Dropdown here -->
                @endif

                <!-- Settings Dropdown -->
<div class="ml-3 relative" x-data="{ open: false }">
    <div>
        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            <div>{{ Auth::user()->name }}</div>

            <div class="ml-1">
                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </div>

    <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50">
        <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('entities.index', ['type' => 'client']) }}" :active="request()->routeIs('entities.index') && request('type') === 'client'">
                Clients
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('entities.index', ['type' => 'supplier']) }}" :active="request()->routeIs('entities.index') && request('type') === 'supplier'">
                Suppliers
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('contacts.index') }}" :active="request()->routeIs('contacts.index')">
                Contacts
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('items.index') }}" :active="request()->routeIs('items.*')">
                Items
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('proposals.index') }}" :active="request()->routeIs('proposals.*')">
                Business Proposals
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('calendar.index') }}" :active="request()->routeIs('calendar.*')">
                Calendar
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
