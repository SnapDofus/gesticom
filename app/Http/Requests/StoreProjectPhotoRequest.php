<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'comment' => 'nullable|string|max:500',
            'task_id' => 'nullable|exists:tasks,id',
        ];
    }

    public function messages(): array
    {
        return [
            'photos.required' => 'Veuillez sélectionner au moins une photo.',
            'photos.*.max' => 'Chaque photo ne doit pas dépasser 5 Mo.',
            'photos.*.image' => 'Le fichier doit être une image (jpg, jpeg, png).',
        ];
    }
}
