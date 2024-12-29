<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ActivityRateLimitingTrait;
use Illuminate\Validation\ValidationException;

class UpdateTeamRequest extends FormRequest
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
            'english_name' => ['required', 'string', 'max:150'],
            'arabic_name' => ['required', 'string', 'max:150'],
            'color' => ['required', 'hex_color']
        ];
    }

     /**
     * Check for possible duplication in users teams names
     */
    public function ensure_uniqueness()
    {
        $this->ensureIsNotRateLimited('team-update', 15, 'english_name');

        $user = auth()->user();

        $teams = $user->teams()->where('id', '!=', request()->team->id)->get();

        if(!$teams->where('name_en', $this->english_name)->isEmpty()){
            throw ValidationException::withMessages([
                'english_name' => __('This team\'s english name already exists')
            ]);
        }

        if(!$teams->where('name_ar', $this->arabic_name)->isEmpty()){
            throw ValidationException::withMessages([
                'arabic_name' => __('This team\'s arabic name already exists')
            ]);
        }
    }
}
