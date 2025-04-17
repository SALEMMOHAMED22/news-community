<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   UserRequest extends FormRequest
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
            'name' => ['required' , 'string' ,'min:2'],
            'username' => ['required' , 'unique:users,username'],
            'email' => ['required' , 'unique:users,email'],
            'phone' => ['required' , 'unique:users,phone'],
            'image' => ['required'],
            'status' => ['required' , 'sometimes' , 'in:0,1,Active,Not Active'],
            'email_verified_at' => ['required' , 'sometimes' , 'in:0,1,Active,Not Active'],
            'country' => ['required' , 'string' , 'max:150'],
            'city' => ['required' , 'string' , 'max:150'],
            'street' => ['required' , 'string' , 'max:150'],
            'password' => ['required' , 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
}
