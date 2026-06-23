<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'required|in:global,materials,labor,transport,misc',
            'planned_amount' => 'required|numeric|min:0',
            'spent_amount' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'La catégorie est obligatoire.',
            'planned_amount.required' => 'Le montant prévisionnel est obligatoire.',
            'spent_amount.required' => 'Le montant dépensé est obligatoire.',
        ];
    }
}
