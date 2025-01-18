<x-team-layout :team="$team">


  <div class="container mx-auto px-1 ">
    <div class="flex justify-between items-center py-8">

        <!-- Page Header -->
        <div class="truncate">
        <h1 class="text-3xl font-bold truncate ">{{ __(':team Schedule', ['team' => $team['name_'. app()->getLocale()]]) }}</h1>
        </div>

        <div class="flex flex-col md:flex-row md:items-center gap-4">

        <div>
            <a href="{{ route('team.create_match', ['team' => $team]) }}">
        <x-primary-button class="bg-sky-500 hover:bg-sky-400 focus:bg-sky-400 active:bg-sky-400">
            + {{ __('New Match') }}
        </x-primary-button>
        </a>
        </div>

        <div>
        <a href="{{ route('team.create_training', ['team' => $team]) }}">
        <x-primary-button class="bg-sky-500 hover:bg-sky-400 focus:bg-sky-400 active:bg-sky-400">
            + {{ __('New Training') }}
        </x-primary-button>
        </a>
        </div>

        </div>

    </div>

    <div>
            <p class="text-base font-bold">{{ __('Filter By') }}:</p>
    </div>

    <div class="mt-2">
        
        <form action="">
        <div class="flex flex-col rounded-xl border-2 p-4 md:p-0 md:border-none md:rounded-none md:flex-row items-center gap-2">

            <!-- Type -->
            <div>
            <x-input-label value="{{ __('Type') }}" class="px-3" />
            <select name="type" class="rounded-lg" >
                <option value="all" >{{ __('All') }}</option>
                <option value="matches" {{ request()->query('type') === 'matches' || old('type') === 'matches' ? 'selected' : '' }}>{{ __('Matches') }}</option>
                <option value="trainings" {{ request()->query('type') === 'trainings' || old('type') === 'trainings' ? 'selected' : '' }}>{{ __('Trainings') }}</option>
            </select>
            <x-input-error :messages="$errors->first('type')" class="mt-2" />
            </div>

            <!-- From Date -->
            <div>
           <x-input-label value="{{ __('From Date') }}" for="from" class="px-3" />
           <input type="text" placeholder="{{ __('Day/Month/Year') }}" id="customDatePicker" name="from"  value="{{ !is_null(request()->query('from')) ? request()->query('from') : old('from')}}"  class="rounded-full">
           <x-input-error :messages="$errors->first('from')" class="mt-2" />
        </div>

           <!-- To Date -->
           <div>
           <x-input-label value="{{ __('To Date') }}" class="px-3"/>
           <input type="text" placeholder="{{ __('Day/Month/Year') }}" id="customDatePicker" value="{{ !is_null(request()->query('to')) ? request()->query('to') : old('to')}}" name="to" class="rounded-full">
           <x-input-error :messages="$errors->first('to')" class="mt-2" />
        </div>

          <!-- Buttons -->
           <div class="mt-5 gap-4 flex items-center">
            <div>
           <x-primary-button class="bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>
        </div>
        <div>
            <a href="{{ route('teams.show', $team) }}" class="bg-gray-400 p-2 rounded-md">
              {{ __('Reset') }}
           </a>
           </div>
           </div>
           </div>

        </form>
    </div>

    <div class="flex justify-center items-center">
    <!-- Schedule -->
    <div class="rounded border-2 bg-gray-400 mt-8 w-full md:w-3/4 ">
        @forelse($schedule as $key => $events)
        <div class="p-4">
            <p class="text-xl font-bold"> {{ Carbon\Carbon::parse($key)->translatedFormat('l')}} 
                {{Carbon\Carbon::parse($key)->format('d-m-Y')}} {{$key === now()->toDateString() ?  __('(Today)')  : ''}}
            </p>
       @foreach($events as $event)
       @if($event->type === 'match')
       <a href="{{ route('matches.show', ['match' => $event, 'team' => true]) }}">
        <div class="grid grid-cols-3 rounded border-2 mt-3 p-5 bg-white w-full" >
            <!-- Team -->
           <div class="flex items-center font-bold text-2xl w-10 md:w-36 lg:w-60 truncate ">
           <p @class(['team-color', 'bg-white' => ($event->team['suitable-background'] === 'white'), 'bg-black' => ($event->team['suitable-background'] === 'black')])
           style="
            --text-color: {{ $event->team['color'] }};
            --hover-color: var(--text-color) ;
            --hover-bg-color: {{ $event->team['suitable-background'] }};"> {{ $event->team['name_'.app()->getLocale()] }}</p>
           </div>

           <div class="flex justify-center text-center">
            
           <div class="truncate">
            @if($event->status['name_en'] === 'not started')
           <p>{{ $event->time }}</p> 
           @elseif($event->status['name_en'] === 'cancelled')
           <p class="bg-red-500 text-white">{{ __('Cancelled') }}</p> 
           @elseif($event->status['name_en'] === 'posponed')
           <p class="bg-gray-400 text-white">{{ __('Posponed') }}</p> 
           @else
           <p class="text-xl font-bold">
            {{$event->home_team_score}} - {{$event->opponent_team_score}}
           </p> 
           @endif
           <p class="truncate">{{ $event->tournament['name_'. app()->getLocale()] }}</p>
           <p class="text-blue-500">{{ $event->round['name_'. app()->getLocale()] }}</p>
           </div>

           </div>
           <!-- Opponent -->
           <div class="flex justify-start px-8 md:justify-end md:px-0 items-center font-bold truncate text-xl">
           
           <p>{{ $event->opponent['name_'.app()->getLocale()] }}</p>
        
           </div>

        </div>
        </a>
       
        @else
        <a href="{{ route('trainings.edit', ['training' => $event->id]) }}">
        <div class="flex justify-between rounded border-2 mt-3 bg-white w-full p-5">
            <p class="text-xl font-bold">{{$event->training_type['name_' . app()->getLocale()]}} - {{ __('Training') }} <small> ( {{ __('for :hours hours and :minutes minutes', ['hours' => (floor($event->minutes / 60)), 'minutes' => round(($event->minutes % 60))]) }} )</small> </p>
           <div class="flex flex-col">
            @if($event->status['name_en'] != 'not started')
            <p @class(['text-xl',  'font-bold' , 'text-white', 'bg-gray-500' => ($event->status['name_en'] === 'posponed'), 'bg-red-500' => ($event->status['name_en'] === 'cancelled'), 'bg-green-500' => ($event->status['name_en'] === 'finished') ]) > {{ $event->status['name_' . app()->getLocale()] }}</p>
            @else
            <p class="text-xl font-bold">{{ $event->time }}</p>
            @endif
           </div>
        </div>
        </a>
        @endif
        @endforeach
        </div>
        @empty
        <p class="text-xl font-bold">{{ __('There is no results to show') }}</p>
        @endforelse
    </div>
    </div>
  </div>
</x-team-layout>
