<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskFormRequest extends FormRequest
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
            'description' => [ 'required', 'string', 'min:2', 'max:3000' ],
            'deadline_at' => ['required', 'date', 'after_or_equal:' . date('Y-m-d')],
            'responsible_uuid' => ['required', 'string', 'min:36', 'max:36'],
            'priority_uuid' => ['required', 'string', 'min:36', 'max:36'],
            'parent_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
            'file_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
            'repeat_value' => ['nullable', 'numeric', 'min:0', 'max:31'],
            'repeat_period' => ['nullable', 'string', 'min:4', 'max:10'],
        ];
    }

}
