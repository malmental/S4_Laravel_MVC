<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class IncidenciaUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:abierta,en_proceso,cerrada',
            'prioridad' => 'required|in:baja,media,alta',
            'tags' => 'nullable|string',
        ];
    }
}