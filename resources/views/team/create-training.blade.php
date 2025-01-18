<x-team-layout :team="$team">
    <div class="container mx-auto">
      
        <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Create New Training Session With :attribute', ['attribute' => $team['name_' . app()->getLocale()]]) }}</h1>
        <form action="{{ route('trainings.store') }}" method="POST" class="p-8">
            @csrf
            <div class="grid grid-cols-2 gap-x-12 gap-y-4">
                <input type="hidden" name="group" value="team">
                <input type="hidden" name="team" value="{{ $team->id }}">
                <input type="hidden" name="form_page" value="team_page">
          
            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
            <input type="date" name="date" id="customDatePicker" placeholder="{{ __('Day/Month/Year') }}" class="w-full rounded-md">
            <x-input-error :messages="$errors->first('date')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
            <input type="time" name="time" value="{{ old('time') }}" class="w-full rounded-md">
            <x-input-error :messages="$errors->first('time')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Type') }} <span class="text-red-500">*</span></label>
                <select name="type" class="w-full rounded-md">
                    @foreach($data['types'] as $type)
                    <option value="{{ $type->id }}"   {{ old('type') == $type->id ? 'selected' : '' }}>
                        {{ $type['name_' . app()->getLocale()] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Length In Hours') }} <span class="text-red-500">*</span></label>
                <input type="number" name="hours" min="0" max="24" value="{{ old('hours') }}" class="w-full rounded-md"> 
                <x-input-error :messages="$errors->first('hours')" class="mt-2" />
                </div>

                <div>
                <label class="block font-medium text-gray-700 mb-1">{{ __('Length In Minutes') }} <span class="text-red-500">*</span></label>
                <input type="number" name="minutes" min="0" max="59" value="{{ old('minutes') }}" class="w-full rounded-md">
                <x-input-error :messages="$errors->first('minutes')" class="mt-2" />
            </div>


            </div>
            <div class="p-8 flex justify-center">
        <x-primary-button class="bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>

    </div>
        </form>
   </div>
        </div>
    </div>
</x-team-layout>
