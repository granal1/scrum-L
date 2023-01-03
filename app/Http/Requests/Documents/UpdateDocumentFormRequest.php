<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentFormRequest extends FormRequest
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
            'name' => [],
            'incoming_at' => ['nullable', 'date'],
            'incoming_number' => ['nullable', 'string', 'min:1', 'max:255'],
            'incoming_author' => ['nullable', 'string', 'min:2', 'max:255'],
            'number' => ['nullable', 'string', 'min:1', 'max:255'],
            'date' => ['nullable', 'date'],
            'document_and_application_sheets' => ['nullable', 'string', 'min:6', 'max:6'],
            'task_description' => ['nullable', 'string', 'min:2', 'max:3000'],
            'executor' => ['nullable', 'string', 'min:2', 'max:255'],
            'deadline_at' => ['nullable', 'date'],
            'executed_result' => ['nullable', 'string', 'min:2', 'max:3000'],
            'executed_at' => ['nullable', 'date'],
            'file_mark' => ['nullable', 'string', 'min:2', 'max:255']
            //'path' => [],
        ];
    }

}
