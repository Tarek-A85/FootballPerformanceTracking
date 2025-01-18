<x-team-layout :team="$team">
<div class="container mx-auto">
    <h1 class="text-center font-bold text-2xl my-16">{{ __('Your Training Statistics with :team', ['team' => $team['name_'. app()->getLocale()]]) }}</h1>
    <div>
            <p class="text-base font-bold">{{ __('Filter By') }}:</p>
    </div>

    <div class="mt-2">
        
        <form action="">
        <div class="flex flex-col rounded-xl border-2 p-4 md:p-0 md:border-none md:rounded-none md:flex-row items-center gap-2">

            <!-- From Date -->
            <div>
           <x-input-label value="{{ __('From Date') }}" for="from" class="px-3" />
           <input type="text" placeholder="{{ __('Day/Month/Year') }}" id="customDatePicker" name="from"  value="{{ !is_null(request()->query('from')) ? request()->query('from') : old('from')}}"  class="rounded-full">
           <x-input-error :messages="$errors->first('from')" class="mt-2" />
        </div>

           <!-- To Date -->
           <div>
           <x-input-label value="{{ __('To Date') }}" class="px-3"/>
           <input type="text" placeholder="{{ __('Day/Month/Year') }}" id="customDatePicker" value="{{ !is_null(request()->query('to')) ? request()->query('to') : old('to')}}" name="to" class="rounded-full">
           <x-input-error :messages="$errors->first('to')" class="mt-2" />
        </div>

          <!-- Buttons -->
           <div class="mt-5 gap-4 flex items-center">

            <div>
           <x-primary-button class="bg-green-500 hover:bg-green-400 focus:bg-green-400 active:bg-green-400">
            {{ __('Submit') }}
        </x-primary-button>
        </div>
        <div>
            <a href="{{ route('team.training_stats', $team) }}" class="bg-gray-400 p-2 rounded-md">
              {{ __('Reset') }}
           </a>
           </div>

           </div>
           </div>

        </form>

        @if(count($data['numbers']))
        <h1 class="font-bold text-2xl mt-12">{{ __('Trainings') }}</h1>
    <div class="rounded border-2 p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-xl">
       <p class="font-semibold">{{ __('Number Of Trainings') }}:  <span class="bg-blue-500 p-0.5">{{ $data['numbers']['trainings'] }}</span></p>
       <p class="font-semibold">{{ __('Total Time') }}:  <span class="bg-blue-500 p-0.5">{{ __(':hours hours and :minutes minutes', ['hours' => floor($data['numbers']['minutes'] / 60),'minutes' => round($data['numbers']['minutes'] % 60) ]) }} </span>
       </p>
       </div>
    </div>
    <h1 class="font-bold text-2xl mt-12">{{ __('Training Types') }}</h1>
    <div class="rounded border-2 p-5 text-xl">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 font-semibold">
        @foreach($data['numbers']['types'] as $key => $value)
        <div>
         {{'App\Models\TrainingType'::find($key)['name_' . app()->getLocale()]}} : <span class="bg-blue-500 p-0.5">{{$value}} </span>
         </div>
        @endforeach
        </div>
    </div>
        @else
       <h1 class="text-2xl font-bold">{{ __('You Don\'t Have Any Statistics') }}</h1>
    @endif
    </div>
</x-team-layout>
