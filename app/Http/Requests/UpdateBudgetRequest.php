<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'planned_amount' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'planned_amount.required' => 'Le montant prévisionnel est obligatoire.',
        ];
    }
}
