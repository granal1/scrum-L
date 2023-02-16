<?php

namespace App\Http\Requests\OutgoingFiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutgoingFileFormRequest extends FormRequest
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
            'outgoing_at' => ['nullable', 'date'],
            'outgoing_number' => ['nullable', 'string', 'min:1', 'max:255'],
            'destination' => ['nullable', 'string', 'min:2', 'max:255'],
            'number_of_source_document' => ['nullable', 'string', 'min:1', 'max:255'],
            'date_of_source_document' => ['nullable', 'date'],
            'document_and_application_sheets' => ['nullable', 'string', 'min:1', 'max:4'],
            'file_mark' => ['nullable', 'string', 'min:2', 'max:255'],
            'short_description' => ['required', 'string', 'min:1', 'max:255'],
            'executor_name' => ['required', 'string', 'min:2', 'max:100'],
        ];
    }

}
