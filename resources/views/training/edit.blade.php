<x-app-layout>
    <div class="container mx-auto">
      
        <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Edit Your Training Session') }}</h1>
        <form action="{{ route('trainings.update', ['training' => $training]) }}" method="POST" class="p-8">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-2 gap-x-12 gap-y-4">

                <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Team Or Individual Session?') }} <span class="text-red-500">*</span></label>
            <select name="group" class="w-full rounded-md">
                <option value="team" {{ $training->trainable_type === 'team' ? 'selected' : '' }}>{{ __('Team') }}</option>
                <option value="individual" {{ $training->trainable_type === 'user' ? 'selected' : '' }}>
                    {{ __('Individual') }}
                </option>
            </select>
            <x-input-error :messages="$errors->first('group')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Team') }} <small>{{ __('(choose if it is team training)') }}</small><span class="text-red-500">*</span></label>
            <select name="team" class="w-full rounded-md">
                <option value="none">{{ __('None') }}</option>
                @foreach($data['teams'] as $team)
                <option value="{{ $team->id }}"   {{ $training->trainable_type === 'team' && $training->trainable_id === $team->id ? 'selected' : '' }} 
                    {{ (int)request()->query('team') === $team->id ? 'selected' : ''}} >
                    {{ $team['name_' . app()->getLocale()] }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('team')" class="mt-2" />
            </div>
          
            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
            <input type="date" name="date" id="customDatePicker" placeholder="{{ $date }}" class="w-full rounded-md">
            <x-input-error :messages="$errors->first('date')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
            <input type="time" name="time" value="{{ $training->time }}" class="w-full rounded-md">
            <x-input-error :messages="$errors->first('time')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Type') }} <span class="text-red-500">*</span></label>
                <select name="type" class="w-full rounded-md">
                    @foreach($data['types'] as $type)
                    <option value="{{ $type->id }}"   {{ $training->training_type_id === $type->id ? 'selected' : '' }}>
                        {{ $type['name_' . app()->getLocale()] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Length In Hours') }} <span class="text-red-500">*</span></label>
                <input type="number" name="hours" min="0" max="24" value="{{ floor($training->minutes / 60) }}" class="w-full rounded-md"> 
                <x-input-error :messages="$errors->first('hours')" class="mt-2" />
                </div>

                <div>
                <label class="block font-medium text-gray-700 mb-1">{{ __('Length In Minutes') }} <span class="text-red-500">*</span></label>
                <input type="number" name="minutes" min="0" max="59" value="{{ $training->minutes % 60 }}" class="w-full rounded-md">
                <x-input-error :messages="$errors->first('minutes')" class="mt-2" />
            </div>

            <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Status') }} <span class="text-red-500">*</span></label>
        
        <select name="status" class="rounded-md w-full">
            @foreach($data['statuses'] as $status)
            <option value="{{ $status->id }}" {{ $status->id === $training->status_id ? 'selected' : '' }}>
                {{ $status['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('status')" class="mt-2" />
    </div>

            </div>
            <div class="mt-5 flex justify-center">
        <x-primary-button class="bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>

    </div>
        </form>
        <div class="px-8 flex flex-col justify-center items-center">
        
        <p class="-mt-4 mb-4 font-bold">{{ __('OR DELETE SESSION') }}</p>
   <form action="{{ route('trainings.destroy', $training) }}" method="POST" class="mx-2">
    @method('DELETE')
    @csrf
    <x-primary-button class="bg-red-500 hover:bg-red-400 focus:bg-red-400 active:bg-red-400" onclick="return confirm('{{ __('Are you sure you want to delete this?') }}')">{{ __('Delete') }}</x-primary-button>
   </form>
   </div>
   </div>
        </div>
    </div>
</x-app-layout>
