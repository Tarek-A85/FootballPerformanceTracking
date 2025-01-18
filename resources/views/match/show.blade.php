<x-team-layout :team="$match->team">
    <div class="container mx-auto">
        <div class="p-16">
        <p class="text-xl font-bold"> {{ Carbon\Carbon::parse($match->date)->translatedFormat('l')}} 
                {{Carbon\Carbon::parse($match->date)->format('d-m-Y')}}
            </p>
      
        <div class="flex justify-center">
            <div class="grid grid-cols-3 rounded border-2 mt-3 p-5 bg-white w-full">

            <div @class(['flex', 'items-center', 'font-bold', 'text-2xl', 'w-10', 'md:w-36', 'lg:w-60', 'truncate', 'team-color', 'bg-white' => ($match->team['suitable-background'] === 'white'), 'bg-black' => ($match->team['suitable-background'] === 'black') ])
            style="
            --text-color: {{ $match->team['color'] }};
            --hover-color: var(--text-color) ;
            --hover-bg-color: {{ $match->team['suitable-background'] }};">
                <p>{{ $match->team['name_' . app()->getLocale()] }}</p>
            </div>

            <div class="text-center">
            @if($match->status['name_en'] === 'not started')
           <p>{{ Carbon\Carbon::parse($match->time)->format('H:i') }}</p> 
           @elseif($match->status['name_en'] === 'cancelled')
           <p class=" text-white"><span class="bg-red-500 p-1">{{ __('Cancelled') }}</span></p> 
           @elseif($match->status['name_en'] === 'posponed')
           <p class=" text-white"><span class="bg-gray-400 p-1">{{ __('Posponed') }}</span></p> 
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
           <form action="{{ route('matches.destroy', ['match' => $match, 'team' => $team]) }}" method="POST">
            @method('DELETE')
            @csrf
            <x-primary-button class="bg-red-500 hover:bg-red-400 focus:bg-red-400 active:bg-red-400"
            onclick="return confirm('{{ __('Are you sure you want to delete this?') }}')">
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
                        <h1 class="text-xl font-semibold ">{{ __('Shots') }} : <span class="text-white bg-blue-500 p-1">{{$match->stats->shots}}</span></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Goals') }} :  <span class="text-white bg-blue-500 p-1">{{$match->stats->goals}}</span>
                        @for($i = 1; $i <= $match->stats->goals; $i++) <i class="fa-solid fa-futbol"></i>@endfor</h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Passes') }} :  <span class="text-white bg-blue-500 p-1">{{$match->stats->passes}}</span></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Assists') }} :  <span class="text-white bg-blue-500 p-1">{{$match->stats->assists}}</span></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Yellow Cards') }} :  <span class="text-white bg-yellow-500 p-1">{{$match->stats->yellows}}</span> </h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Red Cards') }} :  <span class="text-white bg-red-500 p-1">{{$match->stats->reds}} </span></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Headers') }} :  <span class="text-white bg-blue-500 p-1">{{$match->stats->headers}}</span></h1>
                    </div>

                    <div>
                        <h1 class="text-xl font-semibold">{{ __('Rating') }} :  <span class="text-white bg-blue-500 p-1">{{$match->stats->rating}}</span></h1>
                    </div>
                </div>

                <hr class="border-t-1 border-gray-400 mt-1">

                @if(isset($match->stats->report))
                <div class="bg-gray-300">
                <h1 class="text-xl font-semibold p-1 text-center">{{ __('Report') }}</h1>
                <div class="p-2">
                    <p class="text-xl font-semibold text-center ">{{ $match->stats->report }}</p>
                </div>
                </div>
                @endif
                @endif
            </div>
            <div class="flex items-center p-4 gap-4">
                @if(isset($match->stats))
                <a href="{{ route('stats.edit', $match->stats) }}">
            <x-primary-button>{{ __('Edit Statistics') }}</x-primary-button>
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
