<?php

namespace App\View\Components;

use App\Models\Tournament;
use Illuminate\View\Component;
use Illuminate\View\View;

class TournamentLayout extends Component
{

    public function __construct(public Tournament $tournament)
    {}
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.tournament.tournament-app');
    }
}
