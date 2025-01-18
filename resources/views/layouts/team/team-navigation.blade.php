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
                    <x-nav-link :href="route('teams.show', ['team' => $team] )" :active="request()->routeIs('teams.show')"  class="font-semibold">
                        {{ __('Schedule') }} <i class="fa-regular fa-calendar-days mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('team.match_stats', ['team' => $team])" :active="request()->routeIs('team.match_stats')" class="font-semibold">
                        {{ __('Matches Statistics') }} <i class="fa-solid fa-square-poll-vertical mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('team.training_stats', ['team' => $team])" :active="request()->routeIs('team.training_stats')" class="font-semibold">
                        {{ __('Trainings Statistics') }} <i class="fa-solid fa-square-poll-vertical mx-1"></i>
                    </x-nav-link>
                    <x-nav-link :href="route('teams.edit', ['team' => $team] )" :active="request()->routeIs('teams.edit')" class="font-semibold">
                        {{ __('Team Details') }} <i class="fa-solid fa-shirt mx-1"></i>
                    </x-nav-link>
                    
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
            </div>

            <!-- Hamburger -->
            
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('teams.show', ['team' => $team])" :active="request()->routeIs('teams.show')">
                {{ __('Schedule') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tournaments.index')" :active="request()->routeIs('tournaments.index')">
                {{ __('Match Statistics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tournaments.index')" :active="request()->routeIs('tournaments.index')">
                {{ __('Training Statistics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('teams.edit', ['team' => $team] )" :active="request()->routeIs('teams.edit')">
                {{ __('Team Details') }}
            </x-responsive-nav-link>

        </div>
    </div>
</nav>

