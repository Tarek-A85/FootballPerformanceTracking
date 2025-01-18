<x-app-layout>
    <div class="container mx-auto max-w-lg">
    <h1 class="p-8 text-center text-2xl">{{ __('Create New Opponent') }}</h1>
    <form action="{{ route('opponents.store') }}" method="POST" class="p-8">
        @csrf

        <input type="hidden" name="team" value="{{ !is_null($team) ? $team->id : null }}">

        <div>
        <label class="block font-medium text-gray-700 mb-1">{{ __('Opponent Name (English)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="english_name" value="{{ old('english_name') }}" required autofocus dir="ltr" />
        <x-input-error :messages="$errors->first('english_name')" class="mt-2" />
        </div>
       
        <div class="mt-6">
        <label class="block font-medium text-gray-700 mb-1"> {{ __('Opponent Name (Arabic)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="arabic_name" value="{{ old('arabic_name') }}" required dir="rtl" />
        <x-input-error :messages="$errors->first('arabic_name')" class="mt-2" />
        </div>

        <div class="text-center mt-4">
        <x-primary-button class="bg-green-500 my-4 px-8 hover:bg-green-400 focus:bg-green-500 active:bg-green-500">{{ __('Submit') }}</x-primary-button>
        </div>


    </form>
    </div>
</x-app-layout>