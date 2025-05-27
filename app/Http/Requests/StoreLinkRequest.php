<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lienDeSource' => ['required', 'url', 'max:2048'],
            'lienCourte' => ['nullable', 'alpha_num', 'min:3', 'max:20', 'unique:links,shortcut_link'],
            'motDePasse' => ['nullable', 'string', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'lienDeSource.required' => 'Le lien source est obligatoire.',
            'lienDeSource.url' => 'Le lien source doit être une URL valide.',
            'lienCourte.unique' => 'Ce lien court est déjà utilisé.',
            'motDePasse.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ];
    }
}
