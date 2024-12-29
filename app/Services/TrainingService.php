<?php

namespace App\Services;

use App\Models\ActivityStatus;
use App\Models\TrainingSession;
use App\Models\TrainingType;

class TrainingService extends BaseService{

    public function create(): array
    {
        $user = auth()->user();

        $teams = $user->teams;

        $types = TrainingType::get();

        return compact('teams', 'types');
    }

    public function store(array $data)
    {
         $training = TrainingSession::create([
                      'trainable_type' => $data['group'] === 'individual' ? 'user' : $data['group'],
                      'trainable_id' => isset($data['team'])  ? $data['team'] : auth()->id(),
                      'minutes' => $data['hours'] * 60 + $data['minutes'],
                      'date' => $data['date'],
                      'time' => $data['time'],
                      'training_type_id' => $data['type'],
                      'status_id' => ActivityStatus::where('name_en', 'not started')->first()->id
                  ]);
                  
        $this->activity_logger->creation('Training', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'training' => $training
        ]);
    }

    public function edit()
    {
        $user = auth()->user();

        $teams = $user->teams;

        $statuses = ActivityStatus::get();

        $types = TrainingType::get();

        return compact('teams', 'statuses', 'types');
    }

    public function update(TrainingSession $training, array $data)
    {
        $old_date = $training->date;

        $training->update([
            'trainable_type' => $data['group'] === 'individual' ? 'user' : $data['group'],
            'trainable_id' => isset($data['team'])  ? $data['team'] : auth()->id(),
            'minutes' => $data['hours'] * 60 + $data['minutes'],
            'date' => $data['date'] ?? $old_date ,
            'time' => $data['time'],
            'training_type_id' => $data['type'],
            'status_id' => $data['status']
        ]);

        $this->activity_logger->update('Training', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'training' => $training
        ]);
    }

    public function destroy(TrainingSession $training)
    {
        $old_training = $training;

        $training->delete();

        $this->activity_logger->destroy('Training', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'training' => $old_training
        ]);
    }
}