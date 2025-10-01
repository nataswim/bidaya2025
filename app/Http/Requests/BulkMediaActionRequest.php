<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkMediaActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'action' => ['required', 'in:delete,change_category'],
            'media_ids' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:media_categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'action.required' => 'Veuillez sélectionner une action.',
            'action.in' => 'Action non valide.',
            'media_ids.required' => 'Aucun média sélectionné.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ];
    }

    /**
     * Obtenir les IDs des médias depuis le JSON
     */
    public function getMediaIds(): array
    {
        $ids = json_decode($this->input('media_ids'), true);
        return is_array($ids) ? $ids : [];
    }
}