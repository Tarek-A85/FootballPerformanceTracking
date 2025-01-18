<?php

namespace App\Http\Requests\Training;

use App\Actions\CheckActivityContradictingAction;
use App\Models\ActivityStatus;
use App\Traits\ActivityRateLimitingTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateTrainingRequest extends FormRequest
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
            'date' => ['nullable', 'date'],
            'time' => ['required', 'date_format:H:i'] ,
            'type' => ['required', 'exists:training_types,id'],
            'status' => ['required', Rule::exists('activity_statuses', 'id')],
            'hours' => ['required', 'numeric', 'min:0'],
            'minutes' => ['required', 'numeric', 'min:0', 'max:59'] 
        ];
    }

    public function ensure_is_not_busy()
    {
        $this->ensureIsNotRateLimited('training-update', 10, 'my_team');

        $date = (isset($this->date) ? Carbon::parse($this->date) : request()->training->date);

       $busy = $this->check_contradicting_action->execute($date, $this->time, null , request()->training->id);

        if($busy){
            throw ValidationException::withMessages([
                'date' => __('You have another activity in this date and time')
            ]);
        }

        $this->check_minutes_plus_hours_is_not_zero();

        $this->check_future_training_status();
    }

    public function check_minutes_plus_hours_is_not_zero()
    {
        if($this->minutes + $this->hours === 0){
            throw ValidationException::withMessages([
                'hours' => __('The length for the training session is not valid')
            ]);
        }
    }

    /**
     * Check Future Training Is Not Finished
     */
    public function check_future_training_status()
    {
        $date = (isset($this->date) ? $this->date : request()->training->date);

        if($date > now()->toDateString() && ($this->status == ActivityStatus::where('name_en', 'finished')->first()->id)){
            throw ValidationException::withMessages([
                'status' => __('The training is in the future is can\'t be finished')
            ]);
        }
    }
}
