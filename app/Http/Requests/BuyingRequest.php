<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyingRequest extends FormRequest
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
            'location' => 'required',
            'desired_location1' => 'required',
            'desired_location2' => 'nullable',
            'desired_location3' => 'nullable',
            'area' => 'required',
            'images' => 'required|array', // تأكد من أن `images` مصفوفة
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif', // تحقق من كل صورة
            'phone' => 'required',
            'status' => 'required',
        ];

    }
}
