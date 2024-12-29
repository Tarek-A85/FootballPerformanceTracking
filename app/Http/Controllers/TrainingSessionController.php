<?php

namespace App\Http\Controllers;

use App\Http\Requests\Training\StoreTrainingRequest;
use App\Http\Requests\Training\UpdateTrainingRequest;
use App\Models\TrainingSession;
use App\Services\TrainingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{

    protected $training_service;

    public function __construct(TrainingService $training_service)
    {
        $this->training_service = $training_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->training_service->create();

        return view('training.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingRequest $request)
    {
        $request->ensure_is_not_busy();

        $this->training_service->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $training = TrainingSession::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingSession $training)
    {
        $data = $this->training_service->edit();

        $date = Carbon::parse($training['date'])->format('d-m-Y');

        return view('training.edit', compact('training', 'data', 'date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingRequest $request, TrainingSession $training)
    {
        $request->ensure_is_not_busy();

        $this->training_service->update($training, $request->validated());

        return redirect()->back()->with('success', __('The training is updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $training)
    {
        $this->training_service->destroy($training);

        return redirect()->back()->with('success', __('The training is deleted successfully'));
    }
}
