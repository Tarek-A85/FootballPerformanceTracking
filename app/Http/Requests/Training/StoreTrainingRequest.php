<?php

namespace App\Http\Requests\Training;

use App\Actions\CheckActivityContradictingAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Traits\ActivityRateLimitingTrait;
use Carbon\Carbon;

class StoreTrainingRequest extends FormRequest
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
        return [
            'group' => ['required', 'string', 'in:individual,team'],
            'team' => [$this->group === 'team' ? 'required' : 'exclude', Rule::exists('teams', 'id')
                                                                               ->where('user_id', auth()->id())],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'] ,
            'type' => ['required', 'exists:training_types,id'],
            'hours' => ['required', 'numeric', 'min:0', 'max:24'],
            'minutes' => ['required', 'numeric', 'min:0', 'max:59'],
            'form_page' => ['required', 'in:team_page,schedule_page']                                                            
        ];
    }

    public function ensure_is_not_busy()
    {
        $this->ensureIsNotRateLimited('training-creation', 30, 'my_team');

       $busy = $this->check_contradicting_action->execute(Carbon::parse($this->date)->format('Y-m-d'), $this->time);

        if($busy){
            throw ValidationException::withMessages([
                'date' => __('You have another activity in this date and time')
            ]);
        }

        $this->check_minutes_plus_hours_is_not_zero();
    }

    public function check_minutes_plus_hours_is_not_zero()
    {
        if($this->minutes + $this->hours === 0){
            throw ValidationException::withMessages([
                'hours' => __('The length for the training session is not valid')
            ]);
        }
    }
}
