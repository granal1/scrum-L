<?php

namespace App\Http\Requests\ArchiveOutgoingDocuments;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchiveOutgoingDocumentFormRequest extends FormRequest
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
            'short_description' => ['required', 'string', 'min:1', 'max:255'],
            'file' => ['required', 'max:25000000', 'mimes:pdf'], // kb
            'outgoing_at' => ['nullable', 'date'],
            'outgoing_number' => ['nullable', 'string', 'min:1', 'max:255'],
            'number_of_source_document' => ['nullable', 'string', 'min:1', 'max:255'],
            'date_of_source_document' => ['nullable', 'date'],
            'document_and_application_sheets' => ['nullable', 'string', 'min:1', 'max:4'],
            'archive_file' => ['nullable', 'file', 'max:25000000', 'mimes:zip'],
        ];
    }

}
