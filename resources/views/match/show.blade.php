<x-team-layout :team="$match->team">
    <div class="container mx-auto">
        <div class="p-16">
        <p class="text-xl font-bold"> {{ Carbon\Carbon::parse($match->date)->translatedFormat('l')}} 
                {{Carbon\Carbon::parse($match->date)->format('d-m-Y')}}
            </p>
      
        <div class="flex justify-center">
            <div class="grid grid-cols-3 rounded border-2 mt-3 p-5 bg-white w-full">

            <div class="flex items-center font-bold text-2xl w-10 md:w-36 lg:w-60 text-orange-500 truncate">
                <p>{{ $match->team['name_' . app()->getLocale()] }}</p>
            </div>

            <div class="text-center">
            @if($match->status['name_en'] === 'not started')
           <p>{{ Carbon\Carbon::parse($match->time)->format('H:i') }}</p> 
           @elseif($match->status['name_en'] === 'cancelled')
           <p class="bg-red-500 text-white">{{ __('Cancelled') }}</p> 
           @elseif($match->status['name_en'] === 'posponed')
           <p class="bg-gray-400 text-white">{{ __('Posponed') }}</p> 
           @else
           <p class="text-xl font-bold">
            {{$match->home_team_score}} - {{$match->opponent_team_score}}
           </p> 
           @endif
           <p class="truncate">{{ $match->tournament['name_'. app()->getLocale()] }}</p>
           <p class="text-blue-500">{{ $match->round['name_'. app()->getLocale()] }}</p>
            </div>

            <div  class="flex justify-start px-8 md:justify-end md:px-0 items-center font-bold truncate text-2xl">
            <p>{{ $match->opponent['name_' . app()->getLocale()] }}</p>
            </div>

            </div>
            </div>

            <div class="flex justify-center items-center gap-4 mt-6">
           <a href="{{ route('matches.edit', $match ) }}"><x-primary-button class="bg-gray-400 hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-500">
            {{ __('Edit') }}
        </x-primary-button> 
    </a> 
           <form action="{{ route('matches.destroy', $match) }}" method="POST">
            @method('DELETE')
            @csrf
            <x-primary-button class="bg-red-500 hover:bg-red-400 focus:bg-red-400 active:bg-red-400">
                {{ __('Delete') }}
            </x-primary-button> 
        </form>

         </div>

        </div>

       

        <!-- Match stats -->
         @if($match->status['name_en'] === 'finished')
         <div class="p-10">
            <h1 class="text-2xl font-bold">{{ __('Your Statistics') }} <i class="fa-solid fa-square-poll-vertical"></i> </h1>
          
            <div class="rounded border-2 bg-white">
                @if(!isset($match->stats))
                <h1 class="text-xl font-bold">{{ __('No Stats Available') }}</h1>
                @else
                <div class="grid grid-cols-2 gap-4 p-3">
                    <!-- Shots -->
                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Shots') }} :  {{$match->stats->shots}}</h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Goals') }} :  {{$match->stats->goals}} <i class="fa-solid fa-futbol"></i></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Passes') }} :  {{$match->stats->passes}}</h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Assists') }} :  {{$match->stats->assists}}</h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Yellow Cards') }} :  {{$match->stats->yellows}} <i class="fa-solid fa-square text-yellow-500"></i></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Red Cards') }} :  {{$match->stats->reds}} <i class="fa-solid fa-square text-red-500"></i></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Headers') }} :  {{$match->stats->headers}}</h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Rating') }} :  {{$match->stats->rating}}</h1>
                    </div>
                </div>
                @if(isset($match->stats->report))
                <h1 class="text-xl font-semibold p-3">{{ __('Report') }}:</h1>
                <div class="rounded border-2 p-4">
                    <p class="text-xl font-semibold">{{ $match->stats->report }}</p>
                </div>
                @endif
                @endif
            </div>
            <div class="flex items-center p-4 gap-4">
                @if(isset($match->stats))
                <a href="{{ route('stats.edit', $match->stats) }}">
            <x-primary-button>{{ __('Edit') }}</x-primary-button>
            </a>
            @else
            <a href="{{ route('stats.create', $match) }}">
            <x-primary-button>{{ __('Create') }}</x-primary-button>
            </a>
            @endif
            </div>
         </div>

         @endif



        
    </div>
</x-team-layout>
