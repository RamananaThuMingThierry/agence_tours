<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'message' => 'required|string',
            'rating'  => 'required|integer|between:1,5',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => __('validation.testimonial.name_required'),
            'name.string'      => __('validation.testimonial.name_string'),
            'name.max'         => __('validation.testimonial.name_max'),
            
            'message.required' => __('validation.testimonial.message_required'),
            'message.string'   => __('validation.testimonial.message_string'),

            'rating.required'  => __('validation.testimonial.rating_required'),
            'rating.integer'   => __('validation.testimonial.rating_integer'),
            'rating.between'   => __('validation.testimonial.rating_between'),
            
            'image.image'      => __('validation.testimonial.image_image'),
            'image.mimes'      => __('validation.testimonial.image_mimes'),
            'image.max'        => __('validation.testimonial.image_max'),
        ];
    }
}
