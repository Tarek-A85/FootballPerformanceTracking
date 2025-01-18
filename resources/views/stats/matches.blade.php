<x-app-layout>
<div class="container mx-auto px-1">
    <div class="flex justify-between items-center py-8">

        <!-- Page Header -->
        <div class="truncate">
        <h1 class="text-3xl font-bold truncate ">{{ __('Matches Statistics') }}</h1>
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
            <a href="{{ route('stats.matches') }}" class="bg-gray-400 p-2 rounded-md">
              {{ __('Reset') }}
           </a>
           </div>
           </div>
           </div>

        </form>
    </div>
    @if(count($data['numbers']) )
    <h1 class="font-bold text-2xl mt-12">{{ __('Matches') }}</h1>
    <div class="rounded border-2 bg-white p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-xl">
       <p class="font-semibold">{{ __('Number Of Played Matches') }}:  <span class="bg-blue-500 p-0.5">{{ $data['numbers']['matches'] }}</span></p>
       <p class="font-semibold">{{ __('Playing average') }}: <span class="bg-blue-500 p-0.5"> {{ __('A game every :days Days', ['days' => round($data['numbers']['matches_every_x_days'],2) ]) }} </span>
         
       </p>
       </div>
    </div>
    <!-- Shooting -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Shooting And Scoring') }}</h1>
    <div class="rounded border-2 bg-white p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-xl">
        <div>
            <h1 class="font-bold">{{ __('Total Shots') }}  : <span class="bg-blue-500 p-0.5">{{$data['numbers']['shots']}} </span></h1>
        </div>
        
        <div>
            <h1 class="font-bold">{{ __('Total Goals') }}  : <span class="bg-blue-500">{{$data['numbers']['goals']}}<span class="font-bold">x</span> <i class="fa-solid fa-futbol"></i> </span></h1>
        </div>

        <div>
            <h1 class="font-bold">{{ __('Successful Scoring Attempts') }}  : <span class="bg-green-400">{{ round($data['numbers']['successfull_scoring_attempts'], 2) }}</span></h1>
        </div>

        <div>
            <h1 class="font-bold">{{ __('Scoring Average') }} <small>( {{ __('per match') }} )</small>  : <span class="bg-gray-400">{{ round($data['numbers']['scoring_avg'], 2) }}</span></h1>
        </div>
    </div>
    </div>
    <!-- Passing -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Passing And Assisting') }}</h1>
    <div class="rounded border-2 bg-white p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-xl">
        <div>
            <h1 class="font-bold">{{ __('Total Passes') }}  : <span class="bg-blue-500 p-0.5"> {{$data['numbers']['passes']}}</span></h1>
        </div>
        
        <div>
            <h1 class="font-bold">{{ __('Total Assists') }}  : <span class="bg-blue-500 p-0.5">{{$data['numbers']['assists']}}<span class="font-bold">x</span> <i class="fa-solid fa-futbol"></i> </span></h1>
        </div>

        <div>
            <h1 class="font-bold">{{ __('Passing Average') }} <small>( {{ __('per match') }} )</small>  : <span class="bg-gray-400 p-0.5">{{ round($data['numbers']['passing_avg'], 2) }}</span></h1>
        </div>
    </div>
    </div>
    <!-- aerial duels -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Aerial Duels') }}</h1>
    <div class="rounded border-2 bg-white p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-xl">
        <div>
            <h1 class="font-bold">{{ __('Total Headers') }}  : <span class="bg-blue-500 p-0.5"> {{$data['numbers']['headers']}}</span></h1>
        </div>

        <div>
            <h1 class="font-bold">{{ __('Average Headers') }} <small>( {{ __('per match') }} )</small>  : <span class="bg-gray-400 p-0.5">{{ round($data['numbers']['headers_avg'], 2) }}</span></h1>
        </div>
    </div>
    </div>
    <!-- Cards -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Cards') }}<i class="fa-solid fa-square text-yellow-500"></i> <i class="fa-solid fa-square text-red-500"></i></h1>
    <div class="rounded border-2 bg-white p-5">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-xl">
        <div>
            <h1 class="font-bold">{{ __('Total Yellow Cards') }}  : <span class="bg-yellow-400 p-0.5"> {{$data['numbers']['yellows']}} </span></h1>
        </div>
        
        <div>
            <h1 class="font-bold">{{ __('Total Red Cards') }}  : <span class="bg-red-500 p-0.5">{{$data['numbers']['reds']}}  </span></h1>
        </div>

        <div>
            <h1 class="font-bold">{{ __('Yellow Cards Average') }} <small>( {{ __('per match') }} )</small>  : <span class="bg-gray-400 p-0.5">{{ round($data['numbers']['yellows'] / $data['numbers']['matches'], 2) }}</span></h1>
        </div>
    </div>
    </div>
    <!-- Top Teams To Score With -->
    <h1 class="font-bold text-2xl mt-12">{{ __('Top Contributions with Teams') }}<i class="fa-solid fa-shirt "></i></h1>
     <div class="rounded border-2 bg-white p-5">
        <table class="text-lg">
            <tr>
            <th class="px-10 text-center">{{ __('Team') }}</th>
            <th class="px-10 text-center">{{ __('Total Matches') }}</th>
            <th class="px-10 text-center">{{ __('Total Contributions') }}</th>
            <th class="px-10 text-center">{{ __('Goals') }}</th>
            <th class="px-10 text-center">{{ __('Assists') }}</th>
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
                    <td class="px-10 text-center my-4">{{ $value['matches'] }}</td>
                    <td class="px-10 text-center my-4">{{ $value['contribution'] }}</td>
                    <td class="px-10 text-center my-4">{{ $value['goals'] }}</td>
                    <td class="px-10 text-center my-4">{{ $value['assists'] }}</td>
                    </tr>

                    @endforeach
                
            </tbody>
        </table>
     </div>
     <!-- Top Opponents To Score Against -->
     <h1 class="font-bold text-2xl mt-12">{{ __('Top Opponents To Contribute Against') }}<i class="fa-solid fa-shirt text-gray-400"></i></h1>
     <div class="rounded border-2 bg-white p-5">
        <table class="text-lg">
            <tr>
            <th class="px-10 text-center">{{ __('Opponent') }}</th>
            <th class="px-10 text-center">{{ __('Total Matches') }}</th>
            <th class="px-10 text-center">{{ __('Total Contributions') }}</th>
            <th class="px-10 text-center">{{ __('Goals') }}</th>
            <th class="px-10 text-center">{{ __('Assists') }}</th>
            </tr>
            <tbody>
                
                    @foreach($data['opponents'] as $key => $value)
                    <tr class="bg-gray-300 border-b-2 ">
                    <td class="px-10 text-center">{{ $loop->iteration }} - {{'App\Models\Opponent'::find($key)['name_' . app()->getLocale()]}}</td>
                    <td class="px-10 text-center">{{ $value['matches'] }}</td>
                    <td class="px-10 text-center">{{ $value['contribution'] }}</td>
                    <td class="px-10 text-center">{{ $value['goals'] }}</td>
                    <td class="px-10 text-center">{{ $value['assists'] }}</td>
                    </tr>
                    @endforeach
                
            </tbody>
        </table>
     </div>
     <!-- Top Tournaments To Score in -->
     <h1 class="font-bold text-2xl mt-12">{{ __('Top Tournaments To Score in') }} <i class="fa-solid fa-trophy text-yellow-500"></i></h1>
     <div class="rounded border-2 p-5">
        <table class="text-lg">
            <tr>
            <th class="px-10 text-center">{{ __('Tournament') }}</th>
            <th class="px-10 text-center">{{ __('Total Matches') }}</th>
            <th class="px-10 text-center">{{ __('Total Contributions') }}</th>
            <th class="px-10 text-center">{{ __('Average Contribution') }} <small>{{ __('per match') }}</small></th>
            <th class="px-10 text-center">{{ __('Goals') }}</th>
            <th class="px-10 text-center">{{ __('Assists') }}</th>
            </tr>
            <tbody>
               
                    @foreach($data['tournaments'] as $key => $value)
                    <tr class="bg-yellow-500 border-b-2">
                    <td class="px-10 text-center">{{ $loop->iteration }} - {{'App\Models\Tournament'::find($key)['name_' . app()->getLocale()]}}</td>
                    <td class="px-10 text-center">{{ $value['matches'] }}</td>
                    <td class="px-10 text-center">{{ $value['contribution'] }}</td>
                    <td class="px-10 text-center">{{ round($value['contribution'] / $value['matches'], 2) }}</td>
                    <td class="px-10 text-center">{{ $value['goals'] }}</td>
                    <td class="px-10 text-center">{{ $value['assists'] }}</td>
                    </tr>
                    @endforeach
                
            </tbody>
        </table>
     </div>
     @else

    <h1 class="text-2xl font-bold">{{ __('You Don\'t Have Any Statistics') }}</h1>

    

    @endif
</div>
</x-app-layout>