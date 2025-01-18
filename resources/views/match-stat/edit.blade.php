<x-app-layout>
    <div class="container mx-auto">
    <div class="flex justify-center items-center min-h-screen">
   <div class="rounded-lg bg-white border-2 w-full max-w-sm md:max-w-lg ">
   <h1 class="p-4 text-center text-2xl font-bold">{{ __('Update Match Statistics') }}</h1>
   <form action="{{ route('stats.update', $stat) }}" method="POST" class="p-6">
    @method('PUT')
   @csrf
   <div class="grid grid-cols-2 gap-y-6 gap-x-12">

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Shots') }} <span class="text-red-500">*</span></label>
    <input type="number" name="shots" value="{{ $stat->shots }}" class="rounded-md w-full" min="0">
    <x-input-error :messages="$errors->first('shots')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Goals') }} <span class="text-red-500">*</span></label>
    <input type="number" name="goals" value="{{ $stat->goals}}" class="rounded-md w-full" min="0">
    <x-input-error :messages="$errors->first('goals')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Passes') }} <span class="text-red-500">*</span></label>
    <input type="number" name="passes" value="{{ $stat->passes }}" class="rounded-md w-full" min="0">
    <x-input-error :messages="$errors->first('passes')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Assists') }} <span class="text-red-500">*</span></label>
    <input type="number" name="assists" value="{{ $stat->assists }}" class="rounded-md w-full" min="0">
    <x-input-error :messages="$errors->first('assists')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Yellow Cards') }} <span class="text-red-500">*</span></label>
    <input type="number" name="yellows" value="{{ $stat->yellows }}" class="rounded-md w-full" min="0" max="2">
    <x-input-error :messages="$errors->first('yellows')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Red Cards') }} <span class="text-red-500">*</span></label>
    <input type="number" name="reds" value="{{ $stat->reds }}" class="rounded-md w-full" min="0" max="1">
    <x-input-error :messages="$errors->first('reds')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Headers') }} <span class="text-red-500">*</span></label>
    <input type="number" name="headers" value="{{ $stat->headers }}" class="rounded-md w-full" min="0" >
    <x-input-error :messages="$errors->first('headers')" class="mt-2" />
    </div>

    <div>
    <label class="block font-medium text-gray-700 mb-1">{{ __('Rating') }} <span class="text-red-500">*</span></label>
    <input type="number" name="rating" value="{{ $stat->rating }}" class="rounded-md w-full" step="0.1" min="0" max="10">
    <x-input-error :messages="$errors->first('rating')" class="mt-2" />
    </div>

   </div>

   <div class="mt-8">
   <label class="block font-medium text-gray-700 mb-1">{{ __('Report') }} </label>
    <textarea name="report" class="w-full">{{$stat->report}}</textarea>
    <x-input-error :messages="$errors->first('report')" class="mt-2" />
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