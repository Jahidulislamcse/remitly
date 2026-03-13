<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gate if needed
    }

    public function rules(): array
    {
        return [
            'type' => ['required','string','max:100'],
            'percentage' => ['required','numeric','between:0,100'],
        ];
    }
}
