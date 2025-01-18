<nav x-data="{ open: false }" class=" dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  ">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('schedule.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link :href="route('schedule.index')" :active="request()->routeIs('schedule.index')" class="font-semibold">
                        {{ __('Schedule') }}  <i class="fa-regular fa-calendar-days mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.index')" class="font-semibold">
                        {{ __('My Teams') }} <i class="fa-solid fa-shirt mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('tournaments.index')" :active="request()->routeIs('tournaments.index')" class="font-semibold">
                        {{ __('Tournaments') }} <i class="fa-solid fa-trophy mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('stats.matches')" :active="request()->routeIs('stats.matches')" class="font-semibold">
                        {{ __('Matches Statistics') }} <i class="fa-solid fa-square-poll-vertical mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('stats.trainings')" :active="request()->routeIs('stats.trainings')" class="font-semibold">
                        {{ __('Trainings Statistics') }} <i class="fa-solid fa-square-poll-vertical mx-1"></i>
                    </x-nav-link>
                    @if(auth()->user()->is_admin)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
            <div class="p-6 text-gray-500">
            <a href="{{ route('change_locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="hover:text-sky-500">
        <i class="fa-solid fa-globe"></i>
        {{ app()->getLocale() === 'ar' ? 'العربية' : 'en' }}
        </a>
        </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
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
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('schedule.index')" :active="request()->routeIs('schedule.index')">
                {{ __('Schedule') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.index')">
                {{ __('My Teams') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tournaments.index')" :active="request()->routeIs('tournaments.index')">
                {{ __('Tournaments') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('stats.matches')" :active="request()->routeIs('stats.matches')">
                {{ __('Matches Statistics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('stats.trainings')" :active="request()->routeIs('stats.trainings')">
                {{ __('Trainings Statistics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('change_locale', app()->getLocale() === 'ar' ? 'en' : 'ar')" class="hover:text-sky-500">
            <i class="fa-solid fa-globe"></i>
            {{ app()->getLocale() === 'ar' ? 'العربية' : 'en' }}
            </x-responsive-nav-link>
            @if(auth()->user()->is_admin)
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
    </div>
</nav>
