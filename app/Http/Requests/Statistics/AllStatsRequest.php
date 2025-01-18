<?php

namespace App\Http\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class AllStatsRequest extends FormRequest
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
        ];
    }
}
