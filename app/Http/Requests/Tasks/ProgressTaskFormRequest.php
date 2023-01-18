<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class ProgressTaskFormRequest extends FormRequest
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
            'comment' => ['required', 'string', 'min:2', 'max:3000'],
            'done_progress' => ['required', 'numeric', 'min:0', 'max:100'],
            'file_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
            'report' => ['nullable', 'string', 'min:1', 'max:3000'],
            'outgoing_file_uuid' => ['nullable', 'string', 'min:36', 'max:36'],
        ];
    }

}
