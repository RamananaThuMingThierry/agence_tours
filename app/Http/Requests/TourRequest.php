<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
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
        $rules =  [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ];

            
        if ($this->isMethod('post')) {
            $rules['images'] = 'required|array';
            $rules['images.*'] = 'required|image|mimes:jpeg,png,jpg';
        } else {
            $rules['images'] = 'nullable|array';
            $rules['images.*'] = 'nullable|image|mimes:jpeg,png,jpg';
        }

        return $rules;
    }
}
