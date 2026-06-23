<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'quantity_planned' => 'required|numeric|min:0',
            'quantity_purchased' => 'required|numeric|min:0',
            'estimated_price' => 'required|numeric|min:0',
            'actual_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'status' => 'required|in:not_purchased,partially_purchased,fully_purchased',
            'observation' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du matériau est obligatoire.',
        ];
    }
}
