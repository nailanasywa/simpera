<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PoliRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_poli' => 'required|string|max:100|unique:polis,nama_poli'
        ];
    }

    public function messages(): array {
        return [
            'nama_poli.required'    => 'Nama poli wajib diisi',
            'nama_poli.unique'      => 'Nama poli sudah tersedia',
        ];
    }
}
