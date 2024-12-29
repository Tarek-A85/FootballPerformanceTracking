<x-team-layout :team="$team">
    <div class="container mx-auto">
    <div class="min-h-screen flex justify-center items-center">
    <div class="rounded-md bg-white border w-full p-6 max-w-md ">
    
    <h1 class="text-2xl text-center font-bold -mt-2 mb-6">
        {{ __(':team Details', ['team' => $team['name_'. app()->getLocale()]])}}
     </h1>
     <form action="{{ route('teams.update', $team) }}" method="POST">
        @method('PUT')
        @csrf

        <div>
        <label class="block font-medium text-gray-700 mb-1">{{ __('Team Name (English)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="english_name" value="{{ $team->name_en }}" required autofocus dir="ltr" />
        <x-input-error :messages="$errors->first('english_name')" class="mt-2" />
        </div>

        <div class="mt-6">
        <label class="block font-medium text-gray-700 mb-1"> {{ __('Team Name (Arabic)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="arabic_name" value="{{ $team->name_ar }}" required dir="rtl" />
        <x-input-error :messages="$errors->first('arabic_name')" class="mt-2" />
        </div>

        <div class="mt-6">
        <label class="block font-medium text-gray-700 mb-1" >{{ __('Logo or Shirt Color') }} <span class="text-red-500">*</span></label>
        <input type="color" class="w-1/4" name="color" value="{{ $team->color }}" required>
        <x-input-error :messages="$errors->first('color')" class="mt-2" />
        </div>

        <div class="text-center mt-4">
            <x-primary-button class="bg-green-500 my-4 px-8 hover:bg-green-400 focus:bg-green-500 active:bg-green-500">
                {{ __('Update') }}
            </x-primary-button>
        </div>
     </form>
    
     <div class="py-4">
        <h1 class="text-lg font-bold">{{ __('Or Delete The Team') }} <small> ({{ __('That means deleting statistics related to this team') }}) </small></h1>
        <form action="{{ route('teams.destroy', $team) }}" method="POST" class="mt-2">
            @method('DELETE')
            @csrf
        <x-primary-button class="bg-red-500  hover:bg-red-400 active:bg-red-400 focus:bg-red-400"
         onclick="return confirm('{{ __('Are you sure you want to delete this?') }}')">
            {{ __('Delete') }}
        </x-primary-button>
        </form>
    </div>
    </div>
    </div>
    </div>
</x-team-layout>
