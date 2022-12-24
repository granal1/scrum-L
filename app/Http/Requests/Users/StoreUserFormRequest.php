<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'login' => ['required',  'unique:users', 'string', 'min:1', 'max:100'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required',  'unique:users', 'string', 'min:3', 'max:100'],
            'phone' => ['nullable', 'string', 'min:3', 'max:15'],
            'birthday_at' => ['nullable'],
            'password' => ['required', 'string', 'min:2', 'max:50'],
            'comment' => ['nullable'],
            'superior_uuid' => ['nullable', 'string', 'min:36', 'max:36']
        ];
    }

}
