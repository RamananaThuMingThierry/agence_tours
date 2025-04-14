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
            'status' => 'required|in:active,inactive',
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

    public function messages(): array
    {
        return [
            'title.required'       => __('validation.required', ['attribute' => __('tour.title')]),
            'title.string'         => __('validation.string', ['attribute' => __('tour.title')]),
            'title.max'            => __('validation.max.string', ['attribute' => __('tour.title'), 'max' => 255]),

            'description.string'   => __('validation.string', ['attribute' => __('tour.description')]),

            'price.required'       => __('validation.required', ['attribute' => __('tour.price')]),
            'price.numeric'        => __('validation.numeric', ['attribute' => __('tour.price')]),
            'price.min'            => __('validation.min.numeric', ['attribute' => __('tour.price'), 'min' => 0]),

            'status.required'      => __('validation.required', ['attribute' => __('tour.status')]),
            'status.in'            => __('validation.in', ['attribute' => __('tour.status')]),

            'images.required'      => __('validation.required', ['attribute' => __('tour.image')]),
            'images.array'         => __('validation.array', ['attribute' => __('tour.image')]),
            'images.*.required'    => __('validation.required', ['attribute' => __('tour.image')]),
            'images.*.image'       => __('validation.image', ['attribute' => __('tour.image')]),
            'images.*.mimes'       => __('validation.mimes', ['attribute' => __('tour.image'), 'values' => 'jpeg, png, jpg']),
        ];
    }
}
