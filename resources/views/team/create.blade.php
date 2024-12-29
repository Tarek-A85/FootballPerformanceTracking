<x-app-layout>

<div class="min-h-screen flex justify-center items-center">
   <div class="rounded-md bg-white border w-full p-6 max-w-md ">
    <h1 class="text-2xl text-center font-bold -mt-2 mb-6">{{ __('Create New Team')}}</h1>
   
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf

        <div>
        <label class="block font-medium text-gray-700 mb-1">{{ __('Team Name (English)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="english_name" value="{{ old('english_name') }}" required autofocus dir="ltr" />
        <x-input-error :messages="$errors->first('english_name')" class="mt-2" />
        </div>
       
        <div class="mt-6">
        <label class="block font-medium text-gray-700 mb-1"> {{ __('Team Name (Arabic)') }} <span class="text-red-500">*</span></label>
        <x-text-input class="w-full" name="arabic_name" value="{{ old('arabic_name') }}" required dir="rtl" />
        <x-input-error :messages="$errors->first('arabic_name')" class="mt-2" />
        </div>
       
        <div class="mt-6">
        <label class="block font-medium text-gray-700 mb-1" >{{ __('Logo or Shirt Color') }} <span class="text-red-500">*</span></label>
        <input type="color" class="w-1/4" name="color" value="{{ old('color') }}" required>
        <x-input-error :messages="$errors->first('color')" class="mt-2" />
        </div>

        <div class="text-center mt-4">
        <x-primary-button class="bg-green-500 my-4 px-8 hover:bg-green-400 focus:bg-green-500 active:bg-green-500">{{ __('Submit') }}</x-primary-button>
        </div>
    </form>
   </div>
   </div>

</x-app-layout>
