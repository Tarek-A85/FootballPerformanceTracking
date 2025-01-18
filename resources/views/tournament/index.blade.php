<x-app-layout>

    <div class="container mx-auto">
   
        <div class="flex justify-between p-8">
            
            <h1 class="text-3xl font-bold">{{ __('All Tournaments') }}</h1> 
            <a href="{{ route('tournaments.create') }}">
                <x-primary-button class="text-white bg-sky-500 hover:bg-sky-400 focus:bg-sky-400 active:bg-sky-400"> 
                    + {{ __('Add Tournament') }} 
                </x-primary-button>
            </a>
            
           
        </div>
       

        <!-- content -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            @foreach($tournaments as $tournament)
        
            <a href="{{ route('tournaments.show', $tournament) }}">
            <div class="rounded-lg border-2 text-yellow-600 shadow-md p-4 bg-white hover:bg-yellow-600 hover:text-white"> 
            <div class="flex justify-center items-center mb-2" >
            <i class="fa-solid fa-trophy text-5xl"></i>
            </div>
                <div class="flex justify-center ">
                    <h4 class="text-xl font-bold truncate ">{{ $tournament['name_'. app()->getLocale()] }}</h4>
                </div>
            </div>
            </a>

            @endforeach

        </div>
    </div>
      
</x-app-layout>
