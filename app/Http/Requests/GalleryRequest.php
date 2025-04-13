<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'image_url' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|in:publish,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'image_url.required' => __('validation.required', ['attribute' => __('gallery.image')]),
            'image_url.image' => __('validation.image', ['attribute' => __('gallery.image')]),
            'image_url.mimes' => __('validation.mimes', ['attribute' => __('gallery.image')]),
            
            'status.required' => __('validation.required', ['attribute' => __('gallery.status')]),
            'status.in' => __('validation.in', ['attribute' => __('gallery.status')]),
        ];
    }

}
