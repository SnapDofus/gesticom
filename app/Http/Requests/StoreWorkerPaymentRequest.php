<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'observation' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La date du paiement est obligatoire.',
            'amount.required' => 'Le montant est obligatoire.',
        ];
    }
}
