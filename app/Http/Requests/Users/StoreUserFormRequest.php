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
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required',  'unique:users', 'string', 'min:3', 'max:100'],
            'phone' => ['nullable', 'string', 'min:3', 'max:15'],
            'birthday_at' => ['nullable', 'date'],
            'employment_at' => ['nullable', 'date'],
            'position' => ['nullable', 'string', 'min:2', 'max:255'],
            'password' => ['required', 'string', 'min:2', 'max:50'],
            'comment' => ['nullable', 'string', 'min:1', 'max:3000'],
            'superior_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
            'user_status_uuid' => ['required', 'string', 'min:36', 'max:36'],
            'subordinate_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
            'role_uuid.*' => ['required', 'string', 'min:36', 'max:36'],
        ];
    }

}
