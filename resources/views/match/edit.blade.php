<x-app-layout>
   <div class="container mx-auto">
  
   
   <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Edit Match') }}</h1>
   <form action="{{ route('matches.update', $match) }}" method="POST" class="p-6">
    @method('PUT')
    @csrf
    
    <div class="grid grid-cols-2 gap-y-6 gap-x-12">
    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('My Team') }} <span class="text-red-500">*</span></label>
      

        <select name="my_team" class="w-full">
           @foreach($data['teams'] as $team)

           <option value="{{ $team->id }}" {{ $team->id === $match->home_team_id ? 'selected' : '' }}>
            {{ $team['name_' . app()->getLocale()] }}
        </option>

           @endforeach
        </select>
        <x-input-error :messages="$errors->first('my_team')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Opponent Team') }} <span class="text-red-500">*</span></label>
        <select name="opponent_team">
            @foreach($data['opponents'] as $opponent)
            <option value="{{ $opponent->id }}" {{ $opponent->id === $match->opponent_team_id ? 'selected' : '' }}>
                {{ $opponent['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('opponent_team')" class="mt-2" />

       

    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Tournament') }} <span class="text-red-500">*</span></label>
       
        <select name="tournament">
            @foreach($data['tournaments'] as $tournament)
            <option value="{{ $tournament->id }}" {{ $tournament->id === $match->tournament_id ? 'selected' : '' }}>
                {{ $tournament['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('tournament')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Round') }} <span class="text-red-500">*</span></label>
        
        <select name="round" class="rounded-lg">
            @foreach($data['rounds'] as $round)
            <option value="{{ $round->id }}" {{ $round->id === $match->round_id ? 'selected' : '' }}>
                {{ $round['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('round')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
        <input type="date" name="date" class="rounded-md" id="customDatePicker" placeholder="{{ $date }}">
        <x-input-error :messages="$errors->first('date')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
    <input type="time" value="{{ $match->time }}"  name="time" class="rounded-md">
    <x-input-error :messages="$errors->first('time')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Status') }} <span class="text-red-500">*</span></label>
        
        <select name="status" class="rounded-lg">
            @foreach($data['statuses'] as $status)
            <option value="{{ $status->id }}" {{ $status->id === $match->status_id ? 'selected' : '' }}>
                {{ $status['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('status')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Your team score') }}</label>
        <input type="number" name="team_score" value="{{ $match->home_team_score ?? null }}" class="rounded-md" min="0">
        <x-input-error :messages="$errors->first('team_score')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Opponent score') }}</label>
        <input type="number" name="opponent_score" value="{{ $match->opponent_team_score ?? null }}" class="rounded-md" min="0">
        <x-input-error :messages="$errors->first('opponent_score')" class="mt-2" />
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