<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateHomeSlide extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'header' => 'required|min:3|max:50',
            'description' => 'required|min:20|max:255',
            'image' => ['required_if:id,0', 'file', 'mimes:jpg,jpeg,png', 'max:1000'],
        ];
    }
}
