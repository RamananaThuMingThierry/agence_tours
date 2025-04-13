<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('form.name')]),
            'name.string' => __('validation.string', ['attribute' => __('form.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('form.name'), 'max' => 255]),

            'email.required' => __('validation.required', ['attribute' => __('form.email')]),
            'email.email' => __('validation.email', ['attribute' => __('form.email')]),

            'phone.required' => __('validation.required', ['attribute' => __('form.phone')]),
            'phone.string' => __('validation.string', ['attribute' => __('form.phone')]),
            'phone.max' => __('validation.max.string', ['attribute' => __('form.phone'), 'max' => 20]),

            'message.string' => __('validation.string', ['attribute' => __('form.message')]),
        ];
    }
}
