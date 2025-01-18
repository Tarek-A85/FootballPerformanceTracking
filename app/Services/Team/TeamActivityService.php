<?php

namespace App\Services\Team;

use App\Models\Round;
use App\Models\TrainingType;
use App\Services\BaseService;

class TeamActivityService extends BaseService {

 public function create_match()
 {
    $user = auth()->user();

    $opponents = $user->opponents;

    $tournaments = $user->tournaments;

    $rounds = Round::get();

    return compact('opponents', 'tournaments', 'rounds');
 }

 public function create_training()
 {
   $types = TrainingType::get();

   return compact('types');
 }

}