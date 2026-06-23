<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:materials,labor,transport,misc',
            'date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'observation' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Le libellé de la dépense est obligatoire.',
        ];
    }
}
