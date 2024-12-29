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
            <select name="group" class="w-full">
                <option value="team" {{ $training->trainable_type === 'team' ? 'selected' : '' }}>{{ __('Team') }}</option>
                <option value="individual" {{ $training->trainable_type === 'user' ? 'selected' : '' }}>
                    {{ __('Individual') }}
                </option>
            </select>
            <x-input-error :messages="$errors->first('group')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Team') }} <small> {{ __('(choose from here if you will train with team)') }} </small> <span class="text-red-500">*</span></label>
            <select name="team" class="w-full">
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
            <input type="date" name="date" id="customDatePicker" placeholder="{{ $date }}">
            <x-input-error :messages="$errors->first('date')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Time') }} <span class="text-red-500">*</span></label>
            <input type="time" name="time" value="{{ $training->time }}">
            <x-input-error :messages="$errors->first('time')" class="mt-2" />
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Type') }} <span class="text-red-500">*</span></label>
                <select name="type" class="w-full">
                    @foreach($data['types'] as $type)
                    <option value="{{ $type->id }}"   {{ $training->training_type_id === $type->id ? 'selected' : '' }}>
                        {{ $type['name_' . app()->getLocale()] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
            <label class="block font-medium text-gray-700 mb-1">{{ __('Length') }} <span class="text-red-500">*</span></label>
             
                   

                        <div>
                 <x-input-label value="{{ __('hours') }}" />
                <input type="number" name="hours" min="0" value="{{ floor($training->minutes / 60) }}" class=""> 
                <x-input-error :messages="$errors->first('hours')" class="mt-2" />
                </div>

                <div>
                <x-input-label value="{{ __('minutes') }}" />
                <input type="number" name="minutes" min="0" max="59" value="{{ $training->minutes % 60 }}" class="">
                <x-input-error :messages="$errors->first('minutes')" class="mt-2" />
            </div>
                 
            </div>

            <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Status') }} <span class="text-red-500">*</span></label>
        
        <select name="status" class="rounded-lg">
            @foreach($data['statuses'] as $status)
            <option value="{{ $status->id }}" {{ $status->id === $training->status_id ? 'selected' : '' }}>
                {{ $status['name_' . app()->getLocale()] }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->first('status')" class="mt-2" />
    </div>

            </div>
            <div class="p-8">
        <x-primary-button class="bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>

    </div>
        </form>
        <div class="p-4 -mt-6">
        <h4 class="font-bold mb-2">{{ __('Or Delete the session') }}</h4>
   <form action="{{ route('trainings.destroy', $training) }}" method="POST">
    @method('DELETE')
    @csrf
    <x-primary-button class="bg-red-500 hover:bg-red-400 focus:bg-red-400 active:bg-red-400">{{ __('Delete') }}</x-primary-button>
   </form>
   </div>
   </div>
        </div>
    </div>
</x-app-layout>
