<?php

namespace App\Http\Requests\MatchStat;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ActivityRateLimitingTrait;
use Illuminate\Validation\ValidationException;

class StoreStatRequest extends FormRequest
{
    use ActivityRateLimitingTrait;

    protected $stopOnFirstFailure = true;
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
            'shots' => ['required', 'numeric', 'min:0'],
            'goals' => ['required', 'numeric', 'min:0'],
            'passes' => ['required', 'numeric', 'min:0'],
            'assists' => ['required', 'numeric', 'min:0'],
            'yellows' => ['required', 'numeric', 'min:0', 'max:2'],
            'reds' => ['required', 'numeric', 'min:0', 'max:1'],
            'headers' => ['required', 'numeric', 'min:0'],
            'rating' => ['required', 'decimal:0,1', 'min:0', 'max:10'],
            'report' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function check_number_of_goals_and_assists()
    {
        $this->ensureIsNotRateLimited('stat-creation', 20, 'shots');

        $team_goals = request()->match->home_team_score;

        if($this->goals + $this->assists > $team_goals){

            throw ValidationException::withMessages([
                'goals' => __('The number of goals and assists must not exceed the number of team goals')
            ]);
        }

    }

    public function messages()
    {
        return [
            'rating.max' => __('The value of rating field must be less than or equal to 10'),
            'yellows.max' => __('The number of yellow cards must not exceed 2'),
            'reds.max' => __('The number of red cards must not exceed 1'),
        ];
    }
}
