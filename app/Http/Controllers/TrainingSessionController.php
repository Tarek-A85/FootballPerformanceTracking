<?php

namespace App\Http\Controllers;

use App\Http\Requests\Training\StoreTrainingRequest;
use App\Http\Requests\Training\UpdateTrainingRequest;
use App\Models\TrainingSession;
use App\Services\TrainingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        if($request->validated('form_page') === 'schedule_page'){
          
            return redirect()->route('schedule.index', [
                'from' => $request->validated('date'),

                'to' => $request->validated('date')

            ])->with('success', __('The :attribute is created successfully', ['attribute' => __('training')]));
        }
        else{
            return redirect()->route('teams.show', [
                'team' => $request->validated('team'),

                'from' => $request->validated('date'),

                'to' => $request->validated('date')
                
            ])->with('success', __('The :attribute is created successfully', ['attribute' => __('training')]));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingSession $training)
    {
        if(!Gate::allows('manage-training', $training)){
            abort(404);
        }

        $data = $this->training_service->edit();

        $date = Carbon::parse($training['date'])->format('d-m-Y');

        return view('training.edit', compact('training', 'data', 'date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingRequest $request, TrainingSession $training)
    {
        if(!Gate::allows('manage-training', $training)){
            abort(404);
        }

        $request->ensure_is_not_busy();

        $this->training_service->update($training, $request->validated());

        return redirect()->back()->with('success', __('The :attribute is updated successfully', ['attribute' => __('training')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $training)
    {
        if(!Gate::allows('manage-training', $training)){
            abort(404);
        }
        
        $this->training_service->destroy($training);

        return redirect()->route('schedule.index')->with('success', __('The :attribute is deleted successfully', ['attribute' => __('training')]));
    }
}
