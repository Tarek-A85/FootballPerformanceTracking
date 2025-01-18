<x-app-layout>

    <div class="container mx-auto">
   
        <div class="flex justify-between p-8">
            
            <h1 class="text-3xl font-bold">{{ __('My Teams') }}</h1> 
            <a href="{{ route('teams.create') }}">
                <x-primary-button class="text-white bg-sky-500 hover:bg-sky-400 focus:bg-sky-400 active:bg-sky-400"> 
                    + {{ __('Add Team') }} 
                </x-primary-button>
            </a>
            
           
        </div>
       

        <!-- content -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            @foreach($teams as $team)
        
            <a href="{{ route('teams.show', $team) }}">
            <div @class(['rounded-lg', 'border-2' , 'shadow-md' ,'p-4', 'team-color', 'bg-white' => ($team['suitable-background'] === 'white'), 'bg-black' => ($team['suitable-background'] === 'black')]) 
                style="
            --text-color: {{ $team->color }};
            --hover-color: {{ $team['suitable-background'] }} ;
            --hover-bg-color: var(--text-color);">
            <div class="flex justify-center items-center mb-2" >
            <i class="fa-solid fa-shirt text-5xl "></i>
            </div>
                <div class="flex justify-between items-center ">
                    <h4 class="text-xl font-bold truncate ">{{ $team['name_'. app()->getLocale()] }}</h4>
                    <p class="text-xl flex items-center">{{ $team->finished_matches_count}} <i class="fa-solid fa-person-running mx-1"></i></p>
                </div>


            </div>
            </a>

            @endforeach

        </div>
    </div>
      
</x-app-layout>
