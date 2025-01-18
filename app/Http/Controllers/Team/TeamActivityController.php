<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Services\Team\TeamActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamActivityController extends Controller
{
    protected $team_activity_service;

    public function __construct(TeamActivityService $team_activity_service)
    {
        $this->team_activity_service = $team_activity_service;
    }
    
    public function create_match(Team $team)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }
        $data = $this->team_activity_service->create_match();

        return view('team.create-match', compact('team', 'data'));
    }

    public function create_training(Team $team)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }
        
        $data = $this->team_activity_service->create_training();

        return view('team.create-training', compact('team', 'data'));
    }
}
