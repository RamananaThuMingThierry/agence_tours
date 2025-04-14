<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1|max:4',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => __('slide.title_required'),
            'title.max' => __('slide.title_max'),
            'subtitle.max' => __('slide.subtitle_max'),
            'order.required' => __('slide.order_required'),
            'order.integer' => __('slide.order_integer'),
            'order.min' => __('slide.order_min'),
            'order.max' => __('slide.order_max'),
            'image.required' => __('slide.image_required'),
            'image.image' => __('slide.image_image'),
            'image.mimes' => __('slide.image_mimes'),
            'image.max' => __('slide.image_max'),
        ];
    }
}
