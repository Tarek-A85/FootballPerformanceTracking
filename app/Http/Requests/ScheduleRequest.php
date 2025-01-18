<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{

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
            'from' => [isset($this->to) ? 'required' : 'nullable', 'date', 'before_or_equal:to'],
            'to' => [ isset($this->from) ? 'required' : 'nullable', 'date', 'after_or_equal:from'],
            'type' => ['nullable', 'in:all,matches,trainings']
        ];
    }

    /**
     * Showing a readable messages
     */
    public function messages()
    {
        return [
            'from.before_or_equal' => __('The first date must be less or equal the second date'),
            'to.after_or_equal' => __('The first date must be less or equal the second date')
        ];
    }
}
