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

                    <div class="relative" x-data="{ entitiesOpen: false }">
                        <button
                            @click="entitiesOpen = !entitiesOpen"
                            class="inline-flex items-center h-full px-3 py-2 text-sm font-medium
           text-gray-500 hover:text-gray-700
           focus:outline-none transition
           border-b-2 border-transparent hover:border-gray-300">
                            Entities
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>


                        <div
                            x-show="entitiesOpen"
                            @click.away="entitiesOpen = false"
                            x-transition
                            class="absolute left-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                            style="display: none;">
                            <a
                                href="{{ route('entities.index', ['type' => 'client']) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Clients
                            </a>
                            <a
                                href="{{ route('entities.index', ['type' => 'supplier']) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Suppliers
                            </a>
                        </div>
                    </div>


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
                    <x-nav-link href="{{ route('subscriptions.dashboard') }}" :active="request()->routeIs('subscriptions.*')">
                        Billing
                    </x-nav-link>
                </div>
            </div>

            <!-- User & Tenant Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-3">

                <!-- Tenant Switcher -->
                @if(Auth::check() && Auth::user()->tenants->count() > 0)
                <div class="relative" x-data="{ tenantDropdownOpen: false }">
                    <button @click="tenantDropdownOpen = !tenantDropdownOpen"
                        class="flex items-center px-3 py-2 text-xs font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>{{ $currentTenant->name ?? 'Select Tenant' }}</span>
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Tenant Dropdown Menu -->
                    <div x-show="tenantDropdownOpen"
                        @click.away="tenantDropdownOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                        style="display: none;">
                        <div class="py-1">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                Your Tenants
                            </div>
                            @foreach(Auth::user()->tenants as $tenant)
                            <a href="{{ route('tenants.switch', $tenant->id) }}"
                                class="flex items-center px-4 py-2 text-sm {{ isset($currentTenant) && $currentTenant->id === $tenant->id ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                @if(isset($currentTenant) && $currentTenant->id === $tenant->id)
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <span class="w-4 mr-2"></span>
                                @endif
                                <div class="flex-1">
                                    <div class="font-medium">{{ $tenant->name }}</div>
                                    @if($tenant->pivot->role === 'owner')
                                    <div class="text-xs text-gray-500">Owner</div>
                                    @elseif($tenant->pivot->role === 'admin')
                                    <div class="text-xs text-gray-500">Admin</div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                            <div class="border-t border-gray-100"></div>
                            <a href="{{ route('tenants.create') }}"
                                class="flex items-center px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Tenant
                            </a>
                            <a href="{{ route('tenants.index') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Manage Tenants
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50">
                        <div class="rounded-md bg-white shadow-xs">
                            <div class="py-1">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    API Tokens
                                </a>
                                @endif

                                <div class="border-t border-gray-100"></div>

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
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <div x-data="{ entitiesOpen: false }" class="space-y-1">
                <button
                    @click="entitiesOpen = !entitiesOpen"
                    class="w-full flex items-center justify-between px-4 py-2 text-left text-sm font-medium text-gray-600 hover:bg-gray-100">
                    <span>Entities</span>
                    <svg class="h-4 w-4 transform" :class="{ 'rotate-180': entitiesOpen }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="entitiesOpen" x-transition class="ml-4 space-y-1">
                    <x-responsive-nav-link
                        href="{{ route('entities.index', ['type' => 'client']) }}"
                        :active="request()->routeIs('entities.index') && request('type') === 'client'">
                        Clients
                    </x-responsive-nav-link>

                    <x-responsive-nav-link
                        href="{{ route('entities.index', ['type' => 'supplier']) }}"
                        :active="request()->routeIs('entities.index') && request('type') === 'supplier'">
                        Suppliers
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link href="{{ route('contacts.index') }}" :active="request()->routeIs('contacts.index')">
                Contacts
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('items.index') }}" :active="request()->routeIs('items.*')">
                Items
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('proposals.index') }}" :active="request()->routeIs('proposals.*')">
                Business Proposals
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')">
                Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('calendar.index') }}" :active="request()->routeIs('calendar.*')">
                Calendar
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Tenant & User Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <!-- Current Tenant -->
            @if(Auth::check() && isset($currentTenant))
            <div class="px-4 mb-3">
                <div class="text-xs text-gray-500">Current Tenant</div>
                <div class="font-medium text-base text-gray-800">{{ $currentTenant->name }}</div>
            </div>
            @endif

            <!-- User Info -->
            <div class="px-4 mb-3">
                <div class="text-xs text-gray-500">Logged in as</div>
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('tenants.index') }}" :active="request()->routeIs('tenants.*')">
                    My Tenants
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    Profile
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    API Tokens
                </x-responsive-nav-link>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>