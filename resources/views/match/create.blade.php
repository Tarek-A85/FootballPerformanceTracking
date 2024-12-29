<x-app-layout>
   <div class="container mx-auto">
  
   
   <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Create New Match') }}</h1>
   <form action="{{ route('matches.store') }}" method="POST" class="p-6">
   
    @csrf
    
    <div class="grid grid-cols-2 gap-y-6 gap-x-12">
    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('My Team') }} <span class="text-red-500">*</span></label>
        @if($data['teams']->count())

        <select name="my_team" class="w-full">
           @foreach($data['teams'] as $team)

           <option value="{{ $team->id }}" {{ (int)request()->query('team') === $team->id ? 'selected' : '' }}>
            {{ $team['name_' . app()->getLocale()] }}
        </option>

           @endforeach
        </select>
        <x-input-error :messages="$errors->first('my_team')" class="mt-2" />

        @else
        <div class="flex items-center gap-4">
        <p class="text-lg text-red-500">{{ __('You are not playing for any team') }}</p>
        <a href="{{ route('teams.create') }}" class="text-blue-500 underline">
            {{ __('Create a new team') }}
        </a>
        </div>
        @endif
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Opponent Team') }} <span class="text-red-500">*</span></label>
        @if($data['opponents']->count())
        <select name="opponent_team">
            @foreach($data['opponents'] as $opponent)
            <option value="{{ $opponent->id }}">{{ $opponent['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('opponent_team')" class="mt-2" />

        @else
        <div class="flex items-center gap-4">
        <p class="text-lg text-red-500">{{ __('You don\'t have any opponent team') }}</p>
        <a href="{{ route('opponents.create') }}" class="text-blue-500 underline">
            {{ __('Create a new opponent team') }}
        </a>
        </div>
        @endif

    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Tournament') }} <span class="text-red-500">*</span></label>
        @if($data['tournaments']->count())
        <select name="tournament">
            @foreach($data['tournaments'] as $tournament)
            <option value="{{ $tournament->id }}" {{ old('tournament') === $tournament ? 'selected' : '' }}>{{ $tournament['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('tournament')" class="mt-2" />

        @else
        <div class="flex items-center gap-4">
           
        <p class="text-lg text-red-500">{{ __('You don\'t have any tournament') }}</p> 
       
        <a href="{{ route('tournaments.create') }}" class="text-blue-500 underline">
            {{ __('Create a new tournament') }}
        </a> 
        </div>
        @endif
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Round') }} <span class="text-red-500">*</span></label>
        @if($data['rounds']->count())
        <select name="round" class="rounded-lg">
            @foreach($data['rounds'] as $round)
            <option value="{{ $round->id }}" {{ old('round') === $round ? 'selected' : '' }}>{{ $round['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('round')" class="mt-2" />

        @else
        <p class="text-lg text-red-500">{{ __('There is no available rounds') }}</p>
        @endif
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
        <input type="date" value="{{ old('date') }}" name="date" class="rounded-md" id="customDatePicker" placeholder="{{ __('Day/Month/Year') }}">
        <x-input-error :messages="$errors->first('date')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
    <input type="time" value="{{ old('time') }}" name="time" class="rounded-md">
    <x-input-error :messages="$errors->first('time')" class="mt-2" />
    </div>
    </div>
    <div class="flex justify-center items-center mt-4 p-4">
        <x-primary-button class=" bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>

    </div>
    
    
   </form>
   </div>
   </div>
   </div>
</x-app-layout>