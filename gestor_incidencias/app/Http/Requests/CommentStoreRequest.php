<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{

public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contenido' => 'required|string',
            'incidencia_id' => 'required|exists:incidencias,id',
            'parent_id' => 'nullable|exists:comments,id',
            'tags' => 'nullable|string',
        ];
    }
}