<?php

namespace App\Http\Requests\Tournament;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ActivityRateLimitingTrait;
use Illuminate\Validation\ValidationException;

class StoreTournamentRequest extends FormRequest
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
        ];
    }

     /**
     * Check for possible duplication in users tournaments names
     */
    public function ensure_uniqueness()
    {

       $this->ensureIsNotRateLimited('tournament-creation', 10, 'english_name');

       $user = auth()->user();

       $user->load('tournaments');

       if(!$user->tournaments->where('name_en', $this->english_name)->isEmpty()){
           throw ValidationException::withMessages([
               'english_name' => __('This tournament\'s english name already exists')
           ]);
       }
        if(!$user->tournaments->where('name_ar', $this->arabic_name)->isEmpty()){
           throw ValidationException::withMessages([
               'arabic_name' => __('This tournament\'s arabic name already exists')
           ]);
       }
    }
}
