<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'middle_name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'mobile_number' => 'required|numeric|digits:10',
            'emergency_contact_number' => 'required|numeric|digits:10',
            'pancard_number' => 'required|string|max:10|min:10|unique:users',
            'adharcard_number' => 'required|string|max:12|min:12|unique:users',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required|string|max:250',
            'birth_date'=>'required',
            'blood_group_id'=>'required',
            'department_id'=>'required',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            
        ];
    }
}