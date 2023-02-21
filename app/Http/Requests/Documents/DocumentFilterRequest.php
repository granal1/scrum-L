<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentFilterRequest extends FormRequest
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
            'short_description' => '',
            'path' => '',
            'content' => '',
            'year' => '',
            'from_day' => '',
            'from_month' => '',
            'to_day' => '',
            'to_month' => '',
        ];
    }
}
