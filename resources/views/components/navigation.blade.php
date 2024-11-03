<nav x-data="{ open: false }">
    <div class="bg-[--primary]">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        @guest
                            <a href="/">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('member') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>
                        @endauth
                    </div> 
                </div>
                
                <x-search-bar class="ml-auto md:w-1/4 w-1/2 my-auto"></x-search-bar>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    @guest
                        <!-- Guest -->
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Log In') }}
                        </x-responsive-nav-link>
                    @endguest
                    @auth
                        <!-- Member -->
                        <x-nav-link :href="route('profile.index')">
                            {{ __('Profile') }}
                        </x-nav-link>
                        @if((auth()->user()->role == 'admin'))
                            <x-nav-link :href="route('admin.index')">
                                {{ __('Users') }}
                            </x-nav-link>
                        @endif
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <!-- Responsive Settings Options -->
            @guest
                <!-- Guest -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Log In') }}
                        </x-responsive-nav-link>
                    </div>
                </div>
            @endguest
            @auth
                <!-- Member -->
                <div class="pb-1">
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.index')" >
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        @if((auth()->user()->role == 'admin'))
                            <x-responsive-nav-link :href="route('admin.index')" >
                                {{ __('Users') }}
                            </x-responsive-nav-link>
                        @endif
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
