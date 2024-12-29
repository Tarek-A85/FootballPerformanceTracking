<?php

namespace App\View\Components;

use App\Models\Team;
use Illuminate\View\Component;
use Illuminate\View\View;

class TeamLayout extends Component
{

    public function __construct(public Team $team)
    {}
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.team.team-app');
    }
}
