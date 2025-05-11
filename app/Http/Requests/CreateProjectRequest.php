<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'alhy'=>'required',
            'area'=>'required',
            'style'=>'required',
            'finish_level'=>'required',
            'house_shape'=>'required',
            'design'=>'required',
            'floor_number'=>'required',
            'sitting_number'=>'required',
            'kitchen_number'=>'required',
            'dining_room'=>'required',
            'guest_bedroom'=>'required',
            'other_room'=>'required',
            'bedroom_number'=>'required',
            'parking_number'=>'required',
            'other_addition'=>'required',
            'notes'=>'required',
        ];
    }
}
