<?php

namespace App\Http\Requests\Team;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Traits\ActivityRateLimitingTrait;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class StoreTeamRequest extends FormRequest
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

        $this->ensureIsNotRateLimited('team-creation', 10, 'english_name');

        $user = auth()->user();

        $user->load('teams');

        if(!$user->teams->where('name_en', $this->english_name)->isEmpty()){
            throw ValidationException::withMessages([
                'english_name' => __('This team\'s english name already exists')
            ]);
        }
         if(!$user->teams->where('name_ar', $this->arabic_name)->isEmpty()){
            throw ValidationException::withMessages([
                'arabic_name' => __('This team\'s arabic name already exists')
            ]);
        }
     }

}
