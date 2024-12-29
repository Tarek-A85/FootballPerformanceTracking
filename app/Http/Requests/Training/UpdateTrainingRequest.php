<?php

namespace App\Http\Requests\Training;

use App\Actions\CheckActivityContradictingAction;
use App\Traits\ActivityRateLimitingTrait;
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
            'team' => [$this->group === 'team' ? 'required' : 'nullable', Rule::exists('teams', 'id')
                                                                               ->where('user_id', auth()->id())],
            'date' => ['nullable', 'date'],
            'time' => ['required', 'date_format:H:i:s'] ,
            'type' => ['required', 'exists:training_types,id'],
            'status' => ['required', Rule::exists('activity_statuses', 'id')],
            'hours' => ['required', 'numeric', 'min:0'],
            'minutes' => ['required', 'numeric', 'min:0', 'max:59'] 
        ];
    }

    public function ensure_is_not_busy()
    {
        $this->ensureIsNotRateLimited('training-update', 10, 'my_team');

       $busy = $this->check_contradicting_action->execute($this->date, $this->time, null , request()->training->id);

        if($busy){
            throw ValidationException::withMessages([
                'date' => __('You have another activity in this date and time')
            ]);
        }
    }
}
