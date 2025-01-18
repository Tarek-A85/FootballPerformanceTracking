<?php

namespace App\Http\Requests\Match;

use App\Models\Opponent;
use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Actions\CheckActivityContradictingAction;
use App\Models\ActivityStatus;
use App\Traits\ActivityRateLimitingTrait;
class UpdateMatchRequest extends FormRequest
{
    use ActivityRateLimitingTrait;

    protected $stopOnFirstFailure = true;

    protected $check_contradicting_action;

    public function __construct(CheckActivityContradictingAction $check_contradicting_action)
    {
        $this->check_contradicting_action = $check_contradicting_action;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $check = ($this->status == ActivityStatus::where('name_en', 'finished')->first()->id);

        return [
            'my_team' => ['required', Rule::exists('teams', 'id')->where('user_id', auth()->id())],
            'opponent_team' => ['required', Rule::exists('opponents', 'id')->where('user_id', auth()->id())],
            'tournament' => ['required', Rule::exists('tournaments', 'id')->where('user_id', auth()->id())],
            'round' => ['required', Rule::exists('rounds', 'id')],
            'date' => ['nullable', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'status' => ['required', Rule::exists('activity_statuses', 'id')],
            'team_score' => [ (!$check ? 'nullable' : 'required'), 'numeric', 'min:0'],
            'opponent_score' => [(!$check ? 'nullable' : 'required'), 'numeric', 'min:0'],
       ];  
    }

    public function ensure_unique_teams()
    {
        $this->ensureIsNotRateLimited('match-update', 10, 'my_team');

        $team_name = Team::find($this->my_team);

        $opponent_name = Opponent::find($this->opponent_team);

        if($team_name === $opponent_name){
            throw  ValidationException::withMessages([
                'my_team' => __('Both teams are the same, please change one of them')
            ]);
        }

        $this->ensure_is_not_busy();

        $this->check_future_match_status();
    }

     /**
      * Checking if the user has an activity in the same date and time
      */
      public function ensure_is_not_busy()
      {
  
          $busy = $this->check_contradicting_action->execute($this->date, $this->time, request()->match->id);
          
          if($busy){
              throw ValidationException::withMessages([
                  'date' => __('You have another activity in this date and time')
              ]);
          }
      }

      /**
       * Ensure Future match is not finished
       */
      public function check_future_match_status()
      {
        $date = (isset($this->date) ? $this->date : request()->match->date);

        if($date > now()->toDateString() && ($this->status == ActivityStatus::where('name_en', 'finished')->first()->id)){
            throw ValidationException::withMessages([
                'status' => __('The game is in the future is can\'t be finished')
            ]);
        }
      }

      public function attributes()
      {
        return [
            'team_score' => __('team score'),
            'opponent_score' => __('opponent score')

        ];
      }
}
