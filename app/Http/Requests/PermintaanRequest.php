<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PermintaanRequest extends FormRequest
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
            'pasien_id'             => 'required|exists:pasien,id',
            'keperluan'             => 'required|string|max:255',
            'tanggal_permintaan'    => 'required|date'
        ];
    }

    public function messages(): array {
        return [
            'keperluan.required'            => 'Keperluan wajib diisi',
            'tanggal_permintaan.required'   => 'Tanggal wajib diisi'
        ];
    }
}
