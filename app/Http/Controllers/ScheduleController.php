<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Services\ScheduleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class ScheduleController extends Controller
{
    protected $schedule_service;

    public function __construct(ScheduleService $schedule_service)
    {
        $this->schedule_service = $schedule_service;
    }
    public function index(ScheduleRequest $request)
    {
        $schedule = $this->schedule_service->index($request->validated());

        return view('schedule.index', compact('schedule'));
    }
}
