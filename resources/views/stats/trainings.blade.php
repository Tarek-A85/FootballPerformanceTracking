<x-app-layout>
<div class="container mx-auto px-1">
    <div class="flex justify-between items-center py-8">

        <!-- Page Header -->
        <div class="truncate">
        <h1 class="text-3xl font-bold truncate ">{{ __('Trainings Statistics') }}</h1>
        </div>
    </div>
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
            <a href="{{ route('stats.trainings') }}" class="bg-gray-400 p-2 rounded-md">
              {{ __('Reset') }}
           </a>
           </div>
           </div>
           </div>

        </form>
        @if(count($data['numbers']))
        <h1 class="font-bold text-2xl mt-12">{{ __('Trainings') }}</h1>
    <div class="rounded border-2 p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-8 text-xl">
       <p class="font-semibold">{{ __('Number Of Trainings') }}:  <span class="bg-blue-500 p-0.5">{{ $data['numbers']['trainings'] }}</span></p>
       <p class="font-semibold">{{ __('Total Time') }}:  <span class="bg-blue-500 p-0.5">{{ __(':hours hours and :minutes minutes', ['hours' => floor($data['numbers']['minutes'] / 60),'minutes' => round($data['numbers']['minutes'] % 60) ]) }} </span>
       </p>
       <p class="font-semibold">{{ __('Team Trainings') }}: <span class="bg-blue-500 p-0.5">{{ $data['numbers']['team'] }}</span></p>
       <p class="font-semibold">{{ __('Team Trainings Total Time') }}: <span class="bg-blue-500 p-0.5">{{ __(':hours hours and :minutes minutes', ['hours' => floor($data['numbers']['team_minutes'] / 60),'minutes' => round($data['numbers']['team_minutes'] % 60) ]) }}</span></p>
       <p class="font-semibold">{{ __('Individual Trainings') }}: <span class="bg-blue-500 p-0.5">{{ $data['numbers']['user'] }}</span></p>
       <p class="font-semibold">{{ __('Individual Trainings Total Time') }}: <span class="bg-blue-500 p-0.5">{{ __(':hours hours and :minutes minutes', ['hours' => floor($data['numbers']['user_minutes'] / 60),'minutes' => round($data['numbers']['user_minutes'] % 60) ]) }}</span></p>
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
    <!-- Teams Trainings -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Most Training Sessions With Teams') }}</h1>
    <div class="rounded border-2 bg-white p-5">
        @if(count($data['teams']))
        <table class="text-lg">
            <tr>
            <th class="px-10 text-center">{{ __('Team') }}</th>
            <th class="px-10 text-center">{{ __('Total Time') }}</th>
            <th class="px-10 text-center">{{ __('Total Trainings') }}</th>
            </tr>
            <tbody>
               
                    @foreach($data['teams'] as $key => $value)

                    <tr class="team-color border-b-4 border-white"
                         style="
                         background-color: {{ 'App\Models\Team'::find($key)['color'] }};
                          --text-color:  {{ ( 'App\Models\Team'::find($key)['suitable-background'] === 'white' ? 'white': 'black') }};
                          --hover-color: var(--text-color) ;
                          --hover-bg-color:  {{'App\Models\Team'::find($key)['suitable-background'] }};">
                    <td class="px-10 text-center my-4">{{ $loop->iteration }} - {{'App\Models\Team'::find($key)['name_' . app()->getLocale()]}}</td>
                    <td class="px-10 text-center my-4">{{ __(':hours hours and :minutes minutes', ['hours' => (floor($value['minutes'] / 60)), 'minutes' => round( ($value['minutes'] % 60) )]) }}</td>
                    <td class="px-10 text-center my-4">{{ $value['trainings'] }}</td>
                    </tr>

                    @endforeach
                
            </tbody>
        </table>
        @else
        <h1 class="text-2xl font-bold">{{ __('You Don\'t Have Any Statistics With Teams' ) }}</h1>
        @endif
     </div>
        @else
       <h1 class="text-2xl font-bold">{{ __('You Don\'t Have Any Statistics') }}</h1>
    @endif
    </div>
</x-app-layout>