<x-team-layout :team="$team">
   <div class="container mx-auto">
  
   
   <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Create New Match with :attribute', ['attribute' => $team['name_'. app()->getLocale()]]) }}</h1>
   <form action="{{ route('matches.store') }}" method="POST" class="p-6">
   
    @csrf
    
    <div class="grid grid-cols-2 gap-y-6 gap-x-12">
    
    <input type="hidden" name="my_team" value="{{ $team->id }}">
    <input type="hidden" name="form_page" value="team_page">

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Opponent Team') }} <span class="text-red-500">*</span><a href="{{ route('opponents.create', ['team' => $team]) }}" class="mx-1 text-blue-400 underline">{{ __('Create') }}</a></label>
        @if($data['opponents']->count())
        <select name="opponent_team" class="w-full rounded-md">
            @foreach($data['opponents'] as $opponent)
            <option value="{{ $opponent->id }}" {{ old('opponent_team') == $opponent->id ? 'selected' : '' }}>{{ $opponent['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('opponent_team')" class="mt-2" />

        @else
        <div >
        <p class="text-lg text-red-500">{{ __('You don\'t have any opponent teams') }}</p>
        </div>
        @endif

    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Tournament') }} <span class="text-red-500">*</span></label>
        @if($data['tournaments']->count())
        <select name="tournament" class="w-full rounded-md">
            @foreach($data['tournaments'] as $tournament)
            <option value="{{ $tournament->id }}" {{ old('tournament') == $tournament->id ? 'selected' : '' }}>{{ $tournament['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('tournament')" class="mt-2" />

        @else
        <div>
        <p class="text-lg text-red-500">{{ __('You don\'t have any tournaments') }}</p> 
        </div>
        @endif
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Round') }} <span class="text-red-500">*</span></label>
        @if($data['rounds']->count())
        <select name="round" class="rounded-md w-full">
            @foreach($data['rounds'] as $round)
            <option value="{{ $round->id }}" {{ old('round') == $round->id ? 'selected' : '' }}>{{ $round['name_' . app()->getLocale()] }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('round')" class="mt-2" />

        @else
        <p class="text-lg text-red-500">{{ __('There is no available rounds') }}</p>
        @endif
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
        <input type="date" name="date" class="rounded-md w-full" id="customDatePicker" placeholder="{{ __('Day/Month/Year')  }}">
        <x-input-error :messages="$errors->first('date')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
    <input type="time" value="{{ old('time') }}" name="time" class="rounded-md w-full">
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
</x-team-layout>