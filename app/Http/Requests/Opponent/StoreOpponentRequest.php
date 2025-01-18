<?php

namespace App\Http\Requests\Opponent;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ActivityRateLimitingTrait;
use Illuminate\Validation\ValidationException;

class StoreOpponentRequest extends FormRequest
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
            'team' => ['nullable', 'exists:teams,id']
        ];
    }

     /**
     * Check for possible duplication in users opponents names
     */
    public function ensure_uniqueness()
    {

       $this->ensureIsNotRateLimited('opponent-creation', 10, 'english_name');

       $user = auth()->user();

       $user->load('opponents');

       if(!$user->opponents->where('name_en', $this->english_name)->isEmpty()){
           throw ValidationException::withMessages([
               'english_name' => __('This opponent\'s english name already exists')
           ]);
       }
        if(!$user->opponents->where('name_ar', $this->arabic_name)->isEmpty()){
           throw ValidationException::withMessages([
               'arabic_name' => __('This opponent\'s arabic name already exists')
           ]);
       }
    }
}
