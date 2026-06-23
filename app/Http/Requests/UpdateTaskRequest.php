<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stage' => 'required|in:foundation,rebar,formwork,slab,wall_elevation,framing,roofing,electrical,plumbing,tiling,painting,finishing',
            'status' => 'required|in:not_started,in_progress,completed',
            'start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date',
            'actual_end_date' => 'nullable|date',
            'progress' => 'required|integer|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la tâche est obligatoire.',
        ];
    }
}
