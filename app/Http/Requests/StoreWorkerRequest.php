<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'function' => 'nullable|string|max:255',
            'daily_wage' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Le nom complet de l\'ouvrier est obligatoire.',
            'daily_wage.required' => 'Le salaire journalier est obligatoire.',
        ];
    }
}
